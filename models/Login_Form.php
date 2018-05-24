<?php

namespace app\models;

use yii\base\Model;

//登录表单
class Login_Form extends Model
{

    public $email;  //用户邮箱
    public $password;   //用户密码
    public $verifyCode; //验证码

    //表单验证规则
    public function rules()
    {
        return [
            ['email', 'email'], //邮箱格式
            [['email', 'password'], 'required'], //必填字段
            ['verifyCode', 'captcha'],  //验证码规则
        ];
    }

    //验证码标签提示文字
    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
            'password' => '密码',
            'verifyCode' => '请在右面输入验证码',
        ];
    }


}