<?php
namespace app\controllers;

use app\components\BaseController;
use app\models\Userinfo;

class UserController extends BaseController
{
    //关闭post的Csrf验证
    public function init(){
        $this->enableCsrfValidation = false;
    }

    //用户中心
    public function actionUsercenter()
    {
        return $this->render('usercenter');
    }



    //个人信息展示
    public function actionUserinfo(){
        $data = $this->showuserinfo(\Yii::$app->session->get('userid'));
        return $this->render('userinfo',[
            'data'=>$data,
        ]);
    }


    //修改个人信息
    public function actionEdituserinfo(){
        $this->edituserinfo(\Yii::$app->session->get('userid'),$_POST);
        return $this->redirect('/user/userinfo.html?tp=grxx');

    }
    
    //标签管理
    public function actionUsertag(){

        $data = $this->showtag(\Yii::$app->session->get('userid'));

        return $this->render('usertag',[
            'data'=>$data,
        ]);
    }

    //添加标签
    public function actionAddtag($tag=''){
        $state = $this->addtag(\Yii::$app->session->get('userid'),$tag);
        return $state;
    }

    //删除标签
    public function actionDeletag($tag=''){
        $this->deletag(\Yii::$app->session->get('userid'),$tag);
    }



    //修改头像
    public function actionReface(){
        return $this->render('reface');
    }

    //用户头像上传
    public function actionRefacecode()
    {

        if (!$_FILES['Filedata']) {
            die ('Image data not detected!');
        }
        if ($_FILES['Filedata']['error'] > 0) {
            switch ($_FILES ['Filedata'] ['error']) {
                case 1 :
                    $error_log = 'The file is bigger than this PHP installation allows';
                    break;
                case 2 :
                    $error_log = 'The file is bigger than this form allows';
                    break;
                case 3 :
                    $error_log = 'Only part of the file was uploaded';
                    break;
                case 4 :
                    $error_log = 'No file was uploaded';
                    break;
                default :
                    break;
            }
            die ('upload error:' . $error_log);
        } else {
            $img_data = $_FILES['Filedata']['tmp_name'];
            $size = getimagesize($img_data);
            $file_type = $size['mime'];
            if (!in_array($file_type, array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'))) {
                $error_log = 'only allow jpg,png,gif';
                die ('upload error:' . $error_log);
            }
            switch ($file_type) {
                case 'image/jpg' :
                case 'image/jpeg' :
                case 'image/pjpeg' :
                    $extension = 'jpg';
                    break;
                case 'image/png' :
                    $extension = 'png';
                    break;
                case 'image/gif' :
                    $extension = 'gif';
                    break;
            }
        }
        if (!is_file($img_data)) {
            die ('Image upload error!');
        }

        //头像保存路径

        $save_path = dirname(dirname(__FILE__)). "/web/public/userface";

        if (!is_dir($save_path)) {
            mkdir($save_path);
        }

        $uinqid = uniqid();
        $filename = $save_path . '/' . $uinqid . '.' . $extension;

        //更新数据库用户的头像地址
        $this->updateface(\Yii::$app->session->get('userid'),'/public/userface/'.$uinqid . '.' . $extension);

        $result = move_uploaded_file($img_data, $filename);
        if (!$result || !is_file($filename)) {
            die ('Image upload error!');
        }
        echo 'Image data save successed,file:' . $filename;
        exit ();


    }








}