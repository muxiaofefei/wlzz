<?php
namespace app\controllers;

use app\components\BaseController;
use app\models\Login_Form;
use app\models\Register_Form;
use yii;



class RegisterController extends BaseController
{


    //登录
    public function actionLogin()
    {
        $model = new Login_Form();
        if ($model->load(Yii::$app->request->post())) {
            $log = $this->login($model);
            switch ($log)
            {
                case -1:
                    Yii::$app->getSession()->setFlash('success', "您的账号还没有激活哦，快去邮箱看看吧~");
                    break;
                case 0:
                    Yii::$app->getSession()->setFlash('success', "哎呀，登录失败,是不是邮箱或密码输错啦！");
                    break;
                default:
                    Yii::$app->getSession()->setFlash('success', "登录成功,wlzz欢迎您的归来！");
                    return $this->redirect('/site/question.html');
            }
        }

        return $this->render('login',[
            'model'=>$model,
        ]);

    }


    //注册
    public function actionRegister(){
        $model = new Register_Form();
        if ($model->load(Yii::$app->request->post())) {
            $token = $this->register($model);
            $data['email'] = $model['email'];
            $data['username'] = $model['username'];
            $data['token'] = $token;
            return $this->render('index', [
                'data' => $data,
            ]);
        }
        return $this->render('register',[
            'model'=>$model,
        ]);
    }

    //退出登录
    public function actionLoginout(){
        $session = \Yii::$app->session;
        $session->remove('username');
        $session->remove('userid');
        return $this->redirect('/site/question.html');
    }

    //向邮箱发送注册邮件
    public function actionIndex(){
        return $this->render('index', [
        ]);
    }

    //邮箱激活账号
    public function actionActive($verify){
        $state = $this->activeEmail($verify);
        return $this->render('active',[
            'state'=>$state,
        ]);
    }

    //ajax判断邮箱是否重复
    public function actionIssetemal(){
        $email = Yii::$app->request->post('email');
        if(!empty($email)){
            $state = $this->IssetEmail($email);
            return $state;
        }
    }



}