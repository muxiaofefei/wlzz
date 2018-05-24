<?php
use yii\helpers\Url;
$session = \Yii::$app->session;

$tp = isset($_GET['tp'])?$_GET['tp']:'zxdt';
?>
<ul>

    <li>
        <a href="<?=Url::to(['user/usercenter','tp'=>'zxdt'])?>"<?php if($tp == 'zxdt'):?>class="active" <?php endif;?>>
            <i class="icon-home"></i><span>最新动态</span><b class="icon-drop_right"></b>
        </a>
    </li>

    <li>
        <a href="<?=Url::to(['user/userinfo','tp'=>'grxx'])?>" <?php if($tp == 'grxx'):?>class="active" <?php endif;?>>
            <i class="icon-wiki"></i><span>个人信息</span><b class="icon-drop_right"></b>
        </a>
    </li>

    <li>
        <a href="<?=Url::to(['user/usertag','tp'=>'bqgl'])?>" <?php if($tp == 'bqgl'):?>class="active" <?php endif;?>>
            <i class="icon-wiki"></i><span>标签管理</span><b class="icon-drop_right"></b>
        </a>
    </li>



</ul>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>

<script>


    $("a").click(function(){
        $("a").removeClass("active");
        $(this).addClass("active");
    });

</script>