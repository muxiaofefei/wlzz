<?php
error_reporting(0);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>


<style type="text/css">
    .navbar-inverse {
        z-index: 999999;
    }
    .upimg{

        border:#F00 1px solid; width:200px;height:200px
    }

    #sctp{
        position: absolute;
        opacity:0;
        display: block;
        width: 200px;
        height: 200px;
        z-index: 111;

    }
    #tp{
        position: relative;
        top:0px;
        z-index: 0;
    }

    .tag-box span {
        float: left;
        height: 24px;
        background: rgba(7,17,27,.05);
        border-radius: 12px;
        padding: 0 12px;
        color: #4D555D;
        cursor: pointer;
        margin: 8px 8px 0 0;
    }

    .tag-box span.onactive {
        background: #93999F;
        color: #fff;
    }
</style>

<?php $form = ActiveForm::begin(['action' => ['site/updateques','key'=>$_GET['key']],'method'=>'post',]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => 200,value=>$data['title']]) ?>

<!--富文本编辑器-->
<div id="editor"></div>

<textarea id="nr" name="cont" hidden="hidden"></textarea>
<input type="hidden" id="nid" name="nid" value="">
<input type="hidden" id="bq" name="bq" value="">

<?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
<?php echo '　　';?>
<?= Html::Button('删除', ['id'=>'del','class' => 'btn btn-primary', 'name' => 'submit-button']) ?>

<?php ActiveForm::end(); ?>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>


<?php
//删除空格
function trimall($str)
{

    $oldchar = array("
 ", "　", "\t", "\n", "\r");
    $newchar = array("", "", "", "", "");
    return
        str_replace($oldchar, $newchar, $str);
}

?>
<!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
<script type="text/javascript" src="/js/release/wangEditor.min.js"></script>
<script type="text/javascript">

    var E = window.wangEditor
    var editor = new E('#editor')
    // 或者 var editor = new E( document.getElementById('editor') )

    editor.customConfig.uploadImgShowBase64 = true   // 使用 base64 保存图片

    editor.create()
    editor.txt.html('<?=trimall(strip_tags($data['cont'],allow))?>');

</script>

<script>
    // 将富文本编辑器内容添加到表单的文本框中
    $(".w-e-text").bind('input propertychange', function () {
        $('#nr').val(editor.txt.html());
    });


    $("body").on("click","#del", function () {
        $.ajax({
            type: "GET",
            url: '/site/delques.html?key=<?=$_GET['key']?>',
            success: function (data) {
            }
        })
    });

</script>




