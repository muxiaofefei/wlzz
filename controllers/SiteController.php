<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\article;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\UploadForm;
use Yii;
use yii\data\Pagination;
use yii\web\UploadedFile;


class SiteController extends BaseController
{

    //关闭post的Csrf验证
    public function init(){
        $this->enableCsrfValidation = false;
    }

    /**yii 验证码规则
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    //首页
    public function actionIndex()
    {
        return $this->render('index');
    }

    //签到
    public function actionQiandao(){
      $state = $this->qiandao(\Yii::$app->session->get('userid'));
      return $state;
    }

    //问答列表
    public function actionQuestion()
    {
        $data = $this->showquestions();

        foreach ($data as $k=>$v){
            $list = $this->showauthor($v['author']);
            $data[$k]['authorname'] = $list['username'];
        }

        return $this->render('question',[
            'data'=> $data,
        ]);
    }

    //问答列表加载更多
    public function actionMorequestion($page,$pagesize,$q=null,$tags=null){
        if(!empty($q)){
            $data = $this->showquestions($page,$pagesize,1,$q,0);
        }elseif (!empty($tags)){
            $data = $this->showquestions($page,$pagesize,0,$tags,1);
        }else{
            $data = $this->showquestions($page,$pagesize);
        }
        foreach ($data as $k=>$v){
            $list = $this->showauthor($v['author']);
            $data[$k]['authorname'] = $list['username'];
        }
        return json_encode($data);
    }

    //搜索
    public function actionSearch(){
        $data = $this->showquestions(1,10,1,$_GET['q']);
        foreach ($data as $k=>$v){
            $list = $this->showauthor($v['author']);
            $data[$k]['authorname'] = $list['username'];
        }
        if(empty($data)){
            $nosearch = '1';
        }else{
            $nosearch = '0';
        }
        return $this->render('question',[
            'data'=> $data,
            'nosearch' => $nosearch,
        ]);

    }

    //按标签文章列表
    public function actionArticle($tag)
    {
        $data = $this->showquestions(1,20,0,$tag,1);
        foreach ($data as $k=>$v){
            $list = $this->showauthor($v['author']);
            $data[$k]['authorname'] = $list['username'];
        }
        return $this->render('question',[
            'data'=> $data,
        ]);

    }

    //写问题
    public function actionWritequestion()
    {
        if(empty(\Yii::$app->session->get('userid'))){
            Yii::$app->getSession()->setFlash('success', "发布文章是要先登录的哦！");
            return $this->redirect('/register/login.html');
        }
        $model = new article();

        $data = $this->showtag(\Yii::$app->session->get('userid'));

        return $this->render('writequestion',[
            'model'=>$model,
            'data'=>$data,
        ]);
    }

    //保存问题
    public function actionSavequestion(){

        $this->savequestion(\Yii::$app->session->get('userid'),$_POST);
        return $this->redirect('question.html');
    }


    //上传新闻封面图
    public function actionUpnewscover($issrc='',$nid=''){

        //全局变量定义上传类型
        $arrType = array('image/jpg', 'image/gif', 'image/png', 'image/bmp', 'image/pjpeg', 'image/jpeg');

        $path = dirname(dirname(__FILE__));

        $upfile = $path . "\\web\\public\\newscover"; //图片目录路径
        $file = $_FILES['upfile'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { //判断提交方式是否为POST
            if (!is_uploaded_file($file['tmp_name'])) { //判断上传文件是否存在
                echo "<font color='#FF0000'>文件不存在！</font>";
                exit;
            }

            if (!in_array($file['type'], $arrType)) {  //判断图片文件的格式
                $data['state'] = 0;
                $data['message'] = '传文件格式不对';
                return json_encode($data);
                exit;
            }

            if (!file_exists($upfile)) {  // 判断存放文件目录是否存在
                mkdir($upfile, 0777, true);
            }

            $imageSize = getimagesize($file['tmp_name']);
            $img = $imageSize[0] . '*' . $imageSize[1];

            $fname = $file['name'];
            $ftype = explode('.', $fname); //拆分文件得到文件名
            $extension = count($ftype) - 1;

            $uinqid = uniqid();//根据时间生成随机文件名
            $picName = $upfile . "/" . $uinqid . "." . $ftype[$extension]; //保存到本地路径
            $savepath = '/public/newscover/' . $uinqid . "." . $ftype[$extension]; //写入数据库路径

            //存入数据库
            $newsid = $this->upnewscover($savepath,$issrc,$nid);

            if (file_exists($picName)) {
                echo "<font color='#FF0000'>同文件名已存在！</font>";
                exit;
            }
            if (!move_uploaded_file($file['tmp_name'], $picName)) {
                echo "<font color='#FF0000'>移动文件出错！</font>";
                exit;
            }

            $data['state'] = 1;
            $data['savepath'] = $savepath;
            $data['nid']= $newsid;
            return json_encode($data);
        }
    }


    //问答详情
    public function actionQuestioncont($key,$page=1,$pagesize=10){

        $data = $this->showquestioncont($key);
        //获取作者昵称和头像
        $list = $this->showauthor($data['author']);
        $data['authorname'] = $list['username'];
        $data['authorface'] = $list['userface'];
        $data['authorid'] = $list['_id'];
        $data['zan'] = $this->iswzz($key,(string)\Yii::$app->session->get('userid'));
        if(!isset($data['likecount'])){
            $data['likecount'] = 0;
        }
        //主楼层评论
        $data['coms'] = $this->zhcomslist($key,$page,$pagesize);
        $data['comscount'] = $data['coms']['count'];
        unset($data['coms']['count']);
        $pages = new Pagination(['totalCount' => $data['comscount'],'pageSize' => $pagesize]);  //主评论翻页

        foreach ($data['coms'] as $k => $v) {
            $data['coms'][$k]['zan'] = $this->isplz($v['_id'],(string)\Yii::$app->session->get('userid'));
            if(!isset($data['coms'][$k]['likecount'])){
                $data['coms'][$k]['likecount'] = 0;
            }
            $list = $this->showauthor($v['uid']);
            $data['coms'][$k]['username'] = $list['username'];
            $data['coms'][$k]['userface'] = $list['userface'];

            //子楼层回复主楼层评论
            $data['coms'][$k]['zjcoms'] = $this->zcomslist((string)$v['_id'],1,5);
            $data['coms'][$k]['count'] = $data['coms'][$k]['zjcoms']['count'];  //子评论总数
            unset($data['coms'][$k]['zjcoms']['count']);

            foreach ($data['coms'][$k]['zjcoms'] as $kk => $vv) {
                //评论人的信息
                $list = $this->showauthor($vv['uid']);
                $data['coms'][$k]['zjcoms'][$kk]['username'] = $list['username'];
                $data['coms'][$k]['zjcoms'][$kk]['userface'] = $list['userface'];
                //回复对象的信息
                if (isset($vv['fuid'])) {
                    $list = $this->showauthor($vv['fuid']);
                    $data['coms'][$k]['zjcoms'][$kk]['fusername'] = $list['username'];
                }
            }
        }

        //print_r($data);die;

        return $this->render('questioncont',[
            'data'=>$data,
            'pages'=>$pages,    //主评论翻页
        ]);
    }

    //添加评论
    public function actionAddcom(){
        $data = $this->addcom($_POST);
        return json_encode($data);
    }

    //添加回复子评论
    public function actionAddcomszj(){
        $comid = $this->addcomszj($_POST);
        return $comid;
    }

    //删除主评论
    public function actionDelcoms($key){
        $this->delcoms($key);
    }

    //删除子评论
    public function actionDelcomsz($key){
        $this->delcomsz($key);
    }

    //子评论翻页数据
    public function actionZjfy($key,$page){
        $data = $this->zcomslist((string)$key,$page,5);
        unset($data['count']);
        foreach ($data as $k=>$v){
            $list = $this->showauthor($v['uid']);
            $data[$k]['username'] = $list['username'];
            $data[$k]['userface'] = $list['userface'];
            if (isset($v['fuid'])) {
                $list = $this->showauthor($v['fuid']);
                $data[$k]['fusername'] = $list['username'];
            }
        }
        return json_encode($data);
    }

    //文章点赞
    public function actionDzwz($key,$uid,$dz){
        $this->dzwz($key,$uid,$dz);
    }

    //评论点赞
    public function actionDzpl($key,$uid,$dz){
        $this->dzpl($key,$uid,$dz);
    }



    //修改文章
    public function actionEditquestion($key){
        $model = new article();
        $data = $this->showquestioncont($key);
        //print_r($data);die;

        return $this->render('editquestion',[
            'model'=>$model,
            'data'=>$data,
        ]);
    }

    //更新文章内容
    public function actionUpdateques($key){
        $this->updateques($key,$_POST);
        return $this->redirect('questioncont.html?key='.$key);
    }

    //删除文章
    public function actionDelques($key){
        $this->delques($key);
        return $this->redirect('question.html');
    }





    //文件上传
    public function actionUpload()
    {


        //var_dump(is_dir('../upload/'));
        //$path =__DIR__;
        //echo $path;

        $path = dirname(dirname(__FILE__));
        //echo "__FILE__:  ========>  ".__FILE__;


        //is_dir:目录是否存在

        $dir = $path . "\\uploads\\wz";

        if (is_dir($dir)) {
            echo "当前目录下，目录" . $dir . "存在";
        } else {
            echo "当前目录下，目录" . $dir . "不存在";
            mkdir($dir);
        }


        //die;


        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $model->file->saveAs($dir . ' / ' . $model->file->baseName . '.' . $model->file->extension);
            }


        }

        return $this->render('upload', ['model' => $model]);

    }





}
