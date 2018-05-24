<?php
namespace app\widgets\user;
use app\components\BaseController;
use yii\base\Widget;

class UserinfoWidgets extends Widget
{
    public function run()
    {
        $key = $_GET['key'];
        $BASEC = new BaseController();
        $data = $BASEC->showauthorkey($key);
        $list = $BASEC->showauthor($data['author']);
        $data['authorname'] = $list['username'];
        $data['authorface'] = $list['userface'];
        $data['aboutme'] = $list['aboutme'];

        $data['newscount'] = $BASEC->countquestions($list['_id']);
        //print_r($data);die;

        return $this->render('userinfo', [
            'data'=>$data,
        ]);
    }
}