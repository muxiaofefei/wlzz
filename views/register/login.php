<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\helpers\Url;
use yii\bootstrap\Alert;

?>
<a href="/">首页</a>-><a href="<?= Url::to(['register/login'])?>">登录</a>
<br/>
<br/>
<!--提示信息-->
<?php
if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
}
if( Yii::$app->getSession()->hasFlash('error') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-error',
        ],
        'body' => Yii::$app->getSession()->getFlash('error'),
    ]);
} ?>

<?php $form = ActiveForm::begin(['action' => ['register/login'],'method'=>'post',]); ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => 200]) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => 200]) ?>

<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>


<?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>

<?= Html::resetButton('重置', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>


<?php ActiveForm::end(); ?>

<br>
<a href="<?= Url::to(['register/register'])?>">还没有账号？赶快来注册吧!!!</a>

<script type="text/javascript" src="/js/canvas-nest.min.js"></script>
