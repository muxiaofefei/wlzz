<?php
use yii\helpers\Url;
use app\assets\AppAsset;
AppAsset::register($this);
AppAsset::addScript($this,'@web/js/sybj/jquery.particleground.min.js');
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="gb2312" />
    <title>jQuery粒子动态背景特效 - 站长素材</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/sybj/style.css" />
    <style>
        .pg-canvas{
            height: 2000px;
        }
    </style>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
    <script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>
    <script type='text/javascript' src='/js/sybj/demo.js'></script>
</head>

<body>

<div id="particles">
    <div class="intro">
        <h1>wlzz</h1>
        <p>愿得一人心 白首不相离</p>
        <?php
        if(empty(\Yii::$app->session->get('userid'))) {
            ?>
            <a href="<?= Url::to(['register/login']) ?>" class="btn">登录</a>
            <?php
        }
        ?>
    </div>
</div>

</body>
</html>