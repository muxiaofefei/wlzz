<link rel="stylesheet" href="/css/style/usercenter.css">
<body>


<div id="main">
    <div class="login-bg"></div>

    <div class="bg-other user-head-info">
        <div class="user-info clearfix">
            <?= \app\widgets\user\UserheadWidgets::widget();?>
        </div>

    <div class="wrap">

        <div class="slider" style="position: absolute; left: 24px; top: 0px;">

            <?= \app\widgets\user\UserleftWidgets::widget();?>
        </div>
        <div class="u-container">
            <div class="page-home js-usercard-box" id="notices">

                <p class="nodata">暂无任何动态</p>

                <!-- 分页 -->
                <div id="pagenation" class="pagenation"></div>
            </div>
        </div>
    </div>
</div>


</body>