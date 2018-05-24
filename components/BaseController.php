<?php 

namespace app\components;


class BaseController extends \yii\web\Controller {


   //连接数据库
    static function conn() {
        $m = new \MongoClient();    //建立连接
        $db = $m->wlzz;     //选择数据库
        return $db;
    }

    //登录
    public function login($array){

        $db = $this->conn();
        $collection = $db->user;    // 选择集合

        $result = $collection->findOne(
            ["email" => $array['email']],
            [
                "state"=>1,
                "password"=>1,
                "username"=>1,
                "userface"=>1,
            ]
        );

        if($result && $result['state']==0) {
            $state = -1;
        } elseif($result && $result['password']==$array['password']){
            $state = 1;
            $this->usersession($result);
        }else{
            $state = 0;
        }

        return $state;
    }


    //将注册数据写入数据库
    public function register($array)
    {
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合

        $document = array(
            "username" => $array['username'],
            "password" => $array['password'],
            "email" => $array['email'],
            "state" => 0,
            'userface'=>\Yii::$app->params['userface'],
            'tag'=>[],
            'points'=>100,
            'exper'=>0
        );

        $collection->insert($document);    //插入数据

        return $document["_id"];
    }

    //判断数据库是否有此邮箱
    public function IssetEmail($email)
    {
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合
        $result = iterator_to_array($collection->find(["email"=>$email],['email'=>1]));
        empty($result) ? $state = 0 : $state = 1;

        return $state;
    }

    //激活账号
    public function activeEmail($verify){

        $verify=str_replace('"','', $verify); //去除字符串两边的双引号

        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合

        $result = $collection->findOne(
            ["_id" => new \MongoId($verify)],
            [
                "state" => 1,
                "username"=>1,
                "userface"=>1,
            ]
        );

        if($result['state']!=1){
            $collection->update(array("_id" => new\MongoId($verify)), array('$set' => array("state" => "1", 'regtime' => time())));
            $this->usersession($result);
            $state = 1;
        }else{
            $state = 0;
        }

        return $state;
    }

    //签到
    public function qiandao($id){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合
        $collection->update(
            ["_id" => new\MongoId($id)],
            [
                '$inc' => [
                    'exper' => 5,
                    'points'=>5,
                ],
            ]
        );
    }


    //更新用户头像
    public function updateface($id,$filename){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合

        $result = $collection->findOne(["_id" => new \MongoId($id)],['userface'=>1]);

        if ($result['userface'] != \Yii::$app->params['userface']) {
            unlink(dirname(dirname(__FILE__)) . "/web" . $result['userface']);
        }
        $collection->update(array("_id" => new\MongoId($id)), array('$set' => array("userface" => $filename)));
        $session = \Yii::$app->session;
        $session->set('userface',$filename);
    }


    //查看个人信息
    public function showuserinfo($id){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合
        $result = $collection->findOne(
            ["_id" => new \MongoId($id)],
            [
                "sex" => 1,
                "aboutme"=>1,
                "birthday"=>1,
                "home"=>1,
                "company"=>1,
                "school"=>1,
                "username"=>1,
            ]
        );

        return $result;
    }


    //修改个人资料
    public function edituserinfo($id,$array){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合
        $collection->update(
            ["_id" => new\MongoId($id)],
            [
                '$set' => [
                    "username" => $array['nickname'],
                    "sex" => $array['sex'],
                    "aboutme" => $array['aboutme'],
                    "birthday" => $array['YYYY'].'-'.$array['MM'].'-'.$array['DD'],
                    "home" => $array['shen'].'-'.$array['shi'].'-'.$array['qu'],
                    "company" => $array['company'],
                    "school" => $array['school'],
                ]
            ]
        );

        $session = \Yii::$app->session;
        $session->set('username',$array['nickname']);
    }


    //查询用户标签
    public function showtag($id){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合
        $result = $collection->findOne(["_id" => new \MongoId($id)],['tag'=>1]);

        return $result['tag'];
    }


    //添加标签
    public function addtag($id,$tag){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合

        //插入标签
        $result = $collection->update(
            ["_id" => new\MongoId($id)],
            [
                '$addToSet' => [
                    'tag'=>
                        $tag,
                ]
            ]
        );

        $state = $result['nModified'];

        return $state;
    }

    //删除标签
    public function deletag($id,$tag){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合

        $collection->update(
            ["_id" => new\MongoId($id)],
            [
                '$pull' => [
                    'tag'=>
                        $tag,
                ]
            ]
        );

    }


    //上传文章封面图
    public function upnewscover($path,$issrc,$newsid=''){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合
        $src = explode(".",$issrc);
        $n = count($src)-1;

        if($src[$n]=='html'){
            $document = array(
                'newscover'=>$path,
            );
            $collection->insert($document);    //插入数据
            return $document["_id"];
        }else{
            $result = $collection->findOne(["_id" => new \MongoId($newsid)],['newscover'=>1]);
            //删除原来封面图片
            unlink(dirname(dirname(__FILE__)) . "/web" . $result['newscover']);

            $collection->update(
                ["_id" => new\MongoId($newsid)],
                [
                    '$set' => [
                        'newscover' => $path,
                    ]
                ]
            );
            return new\MongoId($newsid);
        }

    }

    //保存问题
    public function savequestion($uid,$array){
        $db = $this->conn();    //创建连接

        //增加用户经验和积分
        $collection = $db->user;    // 选择集合
        $collection->update(
            ["_id" => new\MongoId($uid)],
            [
                '$inc' => [
                    'exper' => 5,
                ],
            ]
        );

        //将问题保存到数据库
        $collection = $db->question;    // 选择集合

        //将前台选择的标签转换成数组
        $bq = explode("-",$array['bq']);
        foreach ($bq as $k=>$v){
            if($v == ''){
                continue;
            }
            $tags[] = $v;
        }
        if(empty($tags)){$tags=[];}

        if(!empty($array['nid'])){
            $collection->update(
                ["_id" => new\MongoId($array['nid'])],
                [
                    '$set' => [
                        'title'=>$array['article']['title'],
                        'author'=>$uid,
                        'cont'=>$array['cont'],
                        'tags'=>$tags,
                        'createtime'=>time(),
                        'click'=>0,
                    ],
                ]
            );
        }else{
            $document = array(
                'title'=>$array['article']['title'],
                'author'=>$uid,
                'cont'=>$array['cont'],
                'tags'=>$tags,
                'createtime'=>time(),
                'click'=>0,
            );
            $collection->insert($document);    //插入数据
        }
    }

    //显示作者信息
    public function showauthor($id){
        $db = $this->conn();    //创建连接
        $collection = $db->user;    // 选择集合
        $result = $collection->findOne(
            ["_id" => new \MongoId($id)],
            [
                "_id" => 1,
                "username" => 1,
                "userface" => 1,
                "aboutme" => 1,
            ]
        );
        return $result;
    }

    //统计用户共发布了多少文章
    public function countquestions($key){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合
        $result = $collection->find(
            ["author" => new\MongoId($key)]
        )->count();
        return $result;
    }

    //显示问题列表
    public function showquestions($page=1,$pagesize=20,$search = 0,$str=null,$label=0){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合
        if($label == 1){
            $result = $collection->find( ["tags" => $str])->sort(['createtime'=>-1])->limit($pagesize)->skip($pagesize*($page-1));
            $result = iterator_to_array($result);
            return $result;
        }
        if($search == 1){
            $result = $collection->find(
                ['title' => new \MongoRegex("/".$str."/")]
            )->sort(['createtime'=>-1])->limit($pagesize)->skip($pagesize*($page-1));
            $result = iterator_to_array($result);
            return $result;
        }else{
            $result = $collection->find()->sort(['createtime'=>-1])->limit($pagesize)->skip($pagesize*($page-1));
            $result = iterator_to_array($result);
            return $result;
        }
    }

    //显示问题详情
    public function showquestioncont($key){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合
        $collection->update(
            ["_id" => new\MongoId($key)],
            [
                '$inc' => [
                    'click'=>1,
                ],
            ]
        );
        $result = $collection->findOne(
            ["_id" => new\MongoId($key)],
            ["like"=>0]
        );

        return $result;
    }

    //查询作者key
    public function showauthorkey($key){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合
        $result = $collection->findOne(
            ["_id" => new\MongoId($key)],
            ["author"=>1]
        );
        return $result;
    }


    //添加主评论
    public function addcom($array)
    {
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合

        $result = $collection->find(
            ["quesid" => $array['newid'],'type'=>'one'],
            ['zlc'=>1]
        )->sort(['createtime'=>-1])->limit(1);
        $result = iterator_to_array($result);
        if(!empty($result)){
            foreach ($result as $k=>$v){
                $zlc = (int)$result[$k]['zlc'] + 1;
            }
        }else{
            $zlc = 1;
        }

        $document = array(
            'quesid'=>$array['newid'], //文章id
            'uid'=>$array['userid'],    //用户id
            'cont'=>$array['com'],      //评论内容
            'createtime' => time(),     //评论时间
            'type'=>'one',
            'zlc'=>$zlc,
        );

        $collection->insert($document);    //插入数据

        return $document;
    }

    //显示评论列表 主楼层评论
    public function zhcomslist($key,$page=1,$pagesize=10){
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合

        $result = $collection->find(
            ["quesid" => $key,'type'=>'one'],
            [
                'uid' => 1,
                'cont' => 1,
                'createtime' => 1,
                'zlc'=>1,
                'likecount'=>1,
            ]
        )->sort(['createtime'=>-1])->limit($pagesize)->skip(($page-1)*$pagesize);
        $result = iterator_to_array($result);

        $result['count'] = $collection->find(
            ["quesid" => $key,'type'=>'one']
        )->count();

        return $result;
    }

    //子楼层评论列表
    public function zcomslist($key,$page=1,$pagesize=5){
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合

        $result = $collection->find(
            ["zhlid" => $key],
            [
                'uid' => 1,
                'cont' => 1,
                'createtime' => 1,
                'fuid'=>1,
            ]
        )->sort(['createtime'=>1])->limit($pagesize)->skip(($page-1)*$pagesize);
        $result = iterator_to_array($result);
        $result['count'] = $collection->find(
            ["zhlid" => $key]
        )->count();
        return $result;
    }

    //添加回复子评论
    public function addcomszj($array){
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合

        $document = array(
            'quesid' => $array['newid'], //文章id
            'uid' => $array['userid'],    //用户id
            'fuid' => $array['fromuid'],     //主评论id
            'cont' => $array['zjcoms'],      //评论内容
            'createtime' => time(),     //评论时间
            'type' => 'two',  //二级子评论
            'zhlid'=>$array['zhlid'],
        );
        $collection->insert($document);    //插入数据

        return $document["_id"];

    }

    //删除主评论
    public function delcoms($key)
    {
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合
        //删除主楼层
        $collection->remove(
            ["_id" => new\MongoId($key)]
        );
        //删除此主楼层下所有子评论
        $collection->remove(
            ["zhlid" => $key]
        );
    }

    //删除子评论
    public function delcomsz($key){
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合
        $collection->remove(
            ["_id" => new\MongoId($key)]
        );
    }

    //评论点赞
    public function dzpl($key,$uid,$dz){
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合
        if($dz == 'true'){
            $result = $collection->update(
                ["_id" => new\MongoId($key)],
                [
                    '$addToSet' => [
                        'like'=>['name'=>$uid],
                    ],
                    '$inc' => [
                        'likecount' => 1,
                    ],
                ]
            );
        }else{
            $result = $collection->update(
                ["_id" => new\MongoId($key)],
                [
                    '$pull' => [
                        'like' => ['name' => $uid],
                    ],
                    '$inc' => [
                        'likecount' => -1,
                    ],
                ]
            );
        }
    }

    //判断文章是否点过赞
    public function isplz($key,$uid){
        $db = $this->conn();    //创建连接
        $collection = $db->quescoms;    // 选择集合

        $result = $collection->find(
            ["_id"=> new \MongoId($key),"like"=>['name'=>$uid]]
        );
        $result = iterator_to_array($result);

        if(!empty($result)){
            $state = 1;
        }else{
            $state = 0;
        }
        return $state;
    }

    //文章点赞
    public function dzwz($key,$uid,$dz){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合

        if($dz == 'true'){
            $result = $collection->update(
                ["_id" => new\MongoId($key)],
                [
                    '$addToSet' => [
                        'like'=>['name'=>$uid],
                    ],
                    '$inc' => [
                        'likecount' => 1,
                    ],
                ]
            );
        }else {
            $result = $collection->update(
                ["_id" => new\MongoId($key)],
                [
                    '$pull' => [
                        'like' => ['name' => $uid],
                    ],
                    '$inc' => [
                        'likecount' => -1,
                    ],
                ]
            );
        }

    }


    //判断文章是否点过赞
    public function iswzz($key,$uid){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合

        $result = $collection->find(
            ["_id"=> new \MongoId($key),"like"=>['name'=>$uid]]
        );
        $result = iterator_to_array($result);

        if(!empty($result)){
            $state = 1;
        }else{
            $state = 0;
        }
        return $state;
    }


    //更新文章
    public function updateques($key,$array){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合
        $collection->update(
            ["_id" => new\MongoId($key)],
            [
                '$set'=>[
                    'title' => $array['article']['title'],
                ]
            ]
        );
        if(!empty($array['cont'])){
            $collection->update(
                ["_id" => new\MongoId($key)],
                [
                    '$set'=>[
                        'cont' => $array['cont'],
                    ]
                ]
            );
        }
    }

    //删除文章
    public function delques($key){
        $db = $this->conn();    //创建连接
        $collection = $db->question;    // 选择集合
        $collection->remove(
            ["_id" => new\MongoId($key)]
        );

    }

    //设置公共变量session
    public function usersession($result){
        $session = \Yii::$app->session;
        $session->set('userid',$result['_id']);
        $session->set('username',$result['username']);
        $session->set('userface',$result['userface']);
    }

}
