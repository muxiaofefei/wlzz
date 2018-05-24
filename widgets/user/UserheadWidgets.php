<?php
namespace app\widgets\user;

use yii\base\Widget;

class UserheadWidgets extends Widget{

    public function run()
    {

        return $this->render('head',[
        ]);
    }
}