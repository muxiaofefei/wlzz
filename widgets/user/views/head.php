<?php
use yii\helpers\Url;
$session = \Yii::$app->session;

?>
<!--头像-->
<div class="user-pic" data-is-fans="" data-is-follows="">
    <div class="user-pic-bg">
        <a href="<?=Url::to(['user/reface'])?>">
            <img class="img" src="<?=$session->get('userface')?>" alt="">
            <div class="reface">
                <span><b>更换头像</b></span>
            </div>
        </a>
    </div>
</div>

<div class="user-info-right">
    <h3 class="user-name clearfix">
        <span><input type="text" value="<?=$session->get('username')?>" style="border: 0"></span>
    </h3>
    <!--25-->
    <p class="about-info">
        <span>保密</span>


        <span>
					学生
					</span>
        <a class="more-user-info"><i class="imv2-arrow2_d"></i>更多信息</a>
    </p>
</div>
<div class="user-sign hide">
    <p class="user-desc">这位同学很懒，木有签名的说～</p>
</div>
<div class="study-info clearfix">
    <div class="item follows">
        <div class="u-info-learn" title="学习时长306小时58分" style="cursor:pointer;">
            <em>306h</em>
            <span>学习时长 </span>
        </div>
    </div>
    <div class="item follows">
        <a href="/u/1986651/experience"><em>25610</em></a>

        <span>经验</span>
    </div>
    <div class="item follows">
        <a href="/u/1986651/credit"><em>4</em></a>

        <span>积分</span>
    </div>
    <div class="item follows">
        <a href="/u/1986651/follows"><em>3</em></a>

        <span>关注</span>
    </div>
    <div class="item follows">
        <a href="/u/1986651/fans"><em>0</em></a>
        <span>粉丝</span>
    </div>
    <div class="item follows"><a href="/user/setbindsns" class="set-btn"><i class="icon-set"></i>个人设置</a></div>


</div><!--.study-info end-->
