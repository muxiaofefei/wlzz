<?php

namespace app\widgets\user;

use yii\base\Widget;

class UserleftWidgets extends Widget{

    public function run()
    {
        return $this->render('left',[
            ]);
    }
}
