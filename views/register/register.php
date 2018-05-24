<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\helpers\Url;
?>
<a href="/">首页</a>-><a href="<?= Url::to(['register/register'])?>">注册</a>
<br/>
<br/>

<?php $form = ActiveForm::begin(['action' => ['register/register'],'method'=>'post',]); ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => 200]) ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => 200]) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => 200]) ?>

<?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 200]) ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>


<?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>

<?= Html::resetButton('重置', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>


<?php ActiveForm::end(); ?>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>

<script type="text/javascript" src="/js/canvas-nest.min.js"></script>

<script>

    //验证邮箱是否存在
    $("#register_form-email").bind('input propertychange', function () {
        var email = $("#register_form-email").val();
        if (email.indexOf('@') != -1) {
            $.ajax({
                type: "POST",
                url: '/register/issetemal.html',
                data: {'email': email},
                success: function (data) {
                    if (data == 1) {
                        alert($("#register_form-email").val() + '已经被注册了');
                        $("#register_form-email").val('');
                        $(".btn")[0].disabled = true;
                    } else {
                        $(".btn")[0].disabled = false;
                    }
                }
            });
        }
    });


</script>


