<?php

namespace app\models;

use yii\base\Model;

class article extends Model{

    public $title;  //用户邮箱

    //表单验证规则
    public function rules()
    {
        return [
            ['title', 'required'], //必填字段
        ];
    }


    //验证码标签提示文字
    public function attributeLabels()
    {
        return [
            'title' => '标题',
        ];
    }

}