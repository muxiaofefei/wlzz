<?php

namespace app\models;

use yii\base\Model;

class Register_Form extends Model{

    public $username;   //用户昵称
    public $email;  //用户邮箱
    public $password;   //用户密码
    public $repassword;   //用户密码
    public $verifyCode; //验证码

    //表单验证规则
    public function rules()
    {
        return [
            ['email', 'email'], //邮箱格式
            [['email', 'password','repassword','username'], 'required'], //必填字段
            [['password'], 'string', 'min' => 6, 'max' => 20],//输入字符的长度
            ['repassword', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致！'],
            ['verifyCode', 'captcha'],  //yii验证码规则
        ];
    }

    //表单控件提示文字
    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
            'username' => '用户昵称',
            'password' => '密码',
            'repassword' => '确认密码',
            'verifyCode' => '请在右面输入验证码',
        ];
    }

}