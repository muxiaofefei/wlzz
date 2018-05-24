<?php
error_reporting(0);

use yii\helpers\Html;
use yii\helpers\Url;

$session = \Yii::$app->session;

?>

<?php
    $home = explode("-",$data['home']);
    $birthday = explode("-",$data['birthday']);

?>


<link rel="stylesheet" href="/css/style/usercenter.css">

<body>

<div class="login-bg"></div>
<div id="main">

    <div class="bg-other user-head-info">
        <div class="user-info clearfix">
            <?= \app\widgets\user\UserheadWidgets::widget(); ?>
        </div>

        <div class="wrap">

            <div class="slider" style="position: absolute; left: 24px; top: 0px;">
                <?= \app\widgets\user\UserleftWidgets::widget(); ?>
            </div>

            <div class="u-container">

                <div id="setting-profile" class="setting-wrap setting-profile">
                    <div class="common-title">
                        个人信息
                        <a id="bjxx" href="javascript: void(0);" class="pull-right js-edit-info">编辑</a>
                    </div>
                    <div class="line"></div>
                    <div class="info-wapper">
                        <div class="info-box clearfix">
                            <label class="pull-left">昵称</label>
                            <div class="pull-left"><?=$data['username']?></div>
                        </div>
                        <div class="info-box clearfix">
                            <label class="pull-left">个性签名</label>
                            <div class="pull-left">
                                <?php if(!empty($data['aboutme'])):?>
                                    <?=$data['aboutme']?>
                                <?php else: ?>
                                    未设置
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="info-box clearfix">
                            <label class="pull-left">性别</label>
                            <div class="pull-left">
                                <?php if(!empty($data['sex'])):?>
                                    <?=$data['sex']?>
                                <?php else: ?>
                                    未设置
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="info-box clearfix">
                            <label class="pull-left">生日</label>
                            <div class="pull-left">
                                <?php if (isset($birthday[1])): ?>
                                    <?= $birthday[0] ?>年<?= $birthday[1] ?>月<?= $birthday[2] ?>日
                                <?php else: ?>
                                    未设置
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="info-box clearfix">
                            <label class="pull-left">故乡</label>
                            <div class="pull-left">
                                <?php if (isset($home[1])): ?>
                                    <?= $home[0] ?><?= $home[1] ?><?= $home[2] ?>
                                <?php else: ?>
                                    未设置
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="info-box clearfix">
                            <label class="pull-left">公司</label>
                            <div class="pull-left">
                            <?php if(!empty($data['company'])):?>
                                <?=$data['company']?>
                            <?php else: ?>
                                未设置
                            <?php endif; ?>
                            </div>
                        </div>
                        <div class="info-box clearfix">
                            <label class="pull-left">学校</label>
                            <div class="pull-left">
                                <?php if(!empty($data['school'])):?>
                                    <?=$data['school']?>
                                <?php else: ?>
                                    未设置
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="editInfo">

                    <div class="moco-modal-title">
                        <div>编辑个人信息</div>
                    </div>
                    <span><a href="javascript:void(0);" class="close-login">X</a></span>

                    <form action="<?= Url::to(['user/edituserinfo']) ?>" method="post" name="userinfo">

                        <div class="moco-form-group">
                            <label for="" class="moco-control-label">昵称：</label>
                            <div class="moco-control-input">
                                <input type="text" name="nickname" id="nick" autocomplete="off"
                                       data-validate="require-nick"
                                       class="moco-form-control" value="<?=$data['username']?>" placeholder="请输入昵称">
                                <div class="rlf-tip-wrap errorHint color-red"></div>
                            </div>
                        </div>


                        <div class="moco-form-group wlfg-wrap">
                            <label for="" class="moco-control-label">个性签名：</label>
                            <div class="moco-control-input">
                                <div class="pr">
                                    <textarea value="<?=$data['aboutme']?>" name="aboutme" id="aboutme" rows="5" class="noresize js-sign moco-form-control"><?=$data['aboutme']?></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="moco-form-group wlfg-wrap">
                            <label for="" class="moco-control-label h16 lh16">性别：</label>
                            <div class="moco-control-input rlf-group rlf-radio-group">
                                <?php if (empty($data['sex'])):?>
                                <label><input type="radio" hidefocus="true" value="保密" name="sex" >保密</label>
                                <label><input type="radio" hidefocus="true" value="男" checked="checked" name="sex">男</label>
                                <label><input type="radio" hidefocus="true" value="女" name="sex">女</label>
                                <?php else: ?>
                                <label><input type="radio" hidefocus="true" value="保密" <?php if($data['sex'] == '保密'){?>checked="checked"<?php }?> name="sex" >保密</label>
                                <label><input type="radio" hidefocus="true" value="男" <?php if($data['sex'] == '男'){?>checked="checked"<?php }?> name="sex">男</label>
                                <label><input type="radio" hidefocus="true" value="女" <?php if($data['sex'] == '女'){?>checked="checked"<?php }?> name="sex">女</label>
                                <?php endif; ?>
                                <div class="rlf-tip-wrap errorHint color-red"></div>
                            </div>
                        </div>


                        <div class="moco-form-group wlfg-wrap __web-inspector-hide-shortcut__">
                            <label for="" class="moco-control-label">生日：</label>
                            <div class="moco-control-input profile-address">
                                <select name="YYYY" onChange="YYYYDD(this.value)">
                                    <?php if (isset($birthday[1])): ?>
                                        <option value="<?= $birthday[0] ?>"><?= $birthday[0] ?>年</option>
                                    <?php endif; ?>
                                    <option value="">请选择 年</option>
                                </select>
                                <select name="MM" onChange="MMDD(this.value)">
                                    <?php if (isset($birthday[1])): ?>
                                        <option value="<?= $birthday[1] ?>"><?= $birthday[1] ?>月</option>
                                    <?php endif; ?>
                                    <option value="">选择 月</option>
                                </select>
                                <select name="DD" onChange="DDD(this.value)">
                                    <?php if (isset($birthday[1])): ?>
                                        <option value="<?= $birthday[2] ?>"><?= $birthday[2] ?>日</option>
                                    <?php endif; ?>
                                    <option value="">选择 日</option>
                                </select>
                            </div>
                        </div>


                        <div class="moco-form-group wlfg-wrap __web-inspector-hide-shortcut__">
                            <label for="" class="moco-control-label">故乡：</label>
                            <div class="moco-control-input profile-address">
                                <div data-toggle="distpicker">
                                    <select name="shen"
                                            <?php if (isset($home[1])){ ?>data-province="<?= $home[0] ?>"<?php } ?>
                                            id="province1"></select>
                                    <select name="shi" <?php if (isset($home[1])){ ?>data-city="<?= $home[1] ?>"
                                            <?php } ?>id="city1"></select>
                                    <select name="qu" <?php if (isset($home[1])){ ?>data-district="<?= $home[2] ?>"
                                            <?php } ?>id="district1"></select>
                                </div>
                            </div>
                        </div>

                        <div class="moco-form-group">
                            <label for="" class="moco-control-label">公司：</label>
                            <div class="moco-control-input">
                                <input type="text" name="company" id="nick" autocomplete="off"
                                       data-validate="require-nick"
                                       class="moco-form-control" value="<?=$data['company']?>" placeholder="请输入公司名称">
                                <div class="rlf-tip-wrap errorHint color-red"></div>
                            </div>
                        </div>

                        <div class="moco-form-group">
                            <label for="" class="moco-control-label">学校：</label>
                            <div class="moco-control-input">
                                <input type="text" name="school" id="nick" autocomplete="off"
                                       data-validate="require-nick"
                                       class="moco-form-control" value="<?=$data['school']?>" placeholder="请输入学校名称">
                                <div class="rlf-tip-wrap errorHint color-red"></div>
                            </div>
                        </div>

                        <div class="infobutton">
                        <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
                        <?= Html::Button('取消', ['class' => 'btn btn-primary close-login', 'name' => 'submit-button']) ?>
                        </div>

                    </form>

                </div>


            </div>

        </div>
    </div>

</div>



</body>

<!--生日-->
<script src="/js/userbirth.js"></script>

<!--地区-->
<script src="http://www.jq22.com/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/distpicker.data.js"></script>
<script src="/js/distpicker.js"></script>

<script>

    $("#bjxx").click(function(){
        $(".editInfo").css('display','block');
        $(".login-bg").css('display','block');

    });

    $('.close-login').click(function () {
        $(".editInfo").css('display','none');
        $(".login-bg").css('display','none');
    })

</script>
