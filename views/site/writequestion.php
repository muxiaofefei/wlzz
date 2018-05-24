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

<?php $form = ActiveForm::begin(['action' => ['site/savequestion'],'method'=>'post',]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => 200]) ?>

<!--富文本编辑器-->
<div id="editor"></div>

<textarea id="nr" name="cont" hidden="hidden"></textarea>
<input type="hidden" id="nid" name="nid" value="">
<input type="hidden" id="bq" name="bq" value="">


<?php if(!empty($data)){ ?>
<div id="js-tags" class="tag-box clearfix">
    <?php foreach ($data as $k=>$v){?>
    <span class="for-choice" tag-id="17" ys="f"><?=$v?></span>
    <?php }?>
</div>
<?php } ?>

<?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>

<?php ActiveForm::end(); ?>

<!--上传封面图-->
<div class="upimg">
    <form name="frm" id="tpsc" action="<?=Url::to(['site/upnewscover'])?>" method="post" enctype="multipart/form-data">
        <input id="sctp" name='upfile' type='file'/>
        <img id="tp" src="" width=200px height=200px>
        <input name="btn" id="upload" type="submit" value="上传" hidden="hidden" /><br />
    </form>
</div>


<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>

<script>

    $('.btn').click(function () {
        var tags = '';
        $(".onactive").each(function(){
        tags = tags+'-'+$(this).html();
        });

        $('#bq').val(tags);
    })

    // 标签切换样式
      var maxbq = 0;
    $(".for-choice").click(function(){
        // 控制选择标签的个数
        if(maxbq < 3){
            if($(this).attr('ys') == 'f'){
                $(this).addClass('onactive');
                $(this).attr('ys','t');
                maxbq++;
            }else {
                $(this).removeClass('onactive');
                $(this).attr('ys','f');
                maxbq--;
            }
        }else {
            if($(this).attr('ys') == 't'){
                $(this).removeClass('onactive');
                $(this).attr('ys','f');
                maxbq--;
            }
        }

    });
</script>


<!--上传封面图-->
<script type="text/javascript">
    // 打开图片后自动提交上传
    $("body").on("change","#sctp",function(){

        var maxSize = 1000;//文件上传大小限制
        var size = document.getElementById('sctp').files[0].size;
        var filesize = (size / 1024).toFixed(2);

        if(filesize < maxSize){
            var isrc= new Array(); //定义一数组
            isrc=$('#tp')[0].src.split("/"); //字符分割
            n = isrc.length-1;
            $.ajax({
                url: '/site/upnewscover.html?issrc='+isrc[n]+'&nid='+$('#nid').val(),
                type: 'POST',
                cache: false,
                data: new FormData($('#tpsc')[0]),
                processData: false,
                contentType: false,
                success: function (data) {
                    var data = JSON.parse(data);
                    // console.log(data);
                    if(data['state'] !== 1){
                        alert(data['message']);
                    }else {
                        // alert(data['nid']['$id']);
                        // console.log(data['nid']);
                        $('#tp').attr('src', data['savepath']);
                        $('#nid').val(data['nid']['$id']);
                    }
                }
            });
        }else{
            alert('上传文件不许大于' + maxSize + 'KB');
        }
    });

</script>


<!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
<script type="text/javascript" src="/js/release/wangEditor.min.js"></script>
<script type="text/javascript">
    var E = window.wangEditor
    var editor = new E('#editor')
    // 或者 var editor = new E( document.getElementById('editor') )

    editor.customConfig.uploadImgShowBase64 = true   // 使用 base64 保存图片

    editor.create()
    editor.txt.html('<p>欢迎使用 <b>wangEditor</b> 富文本编辑器</p>');

</script>

<script>
    var flag = true;
    $(".w-e-text").click(function () {
        if (flag) {
            editor.txt.clear();
            flag = false;
        }
    });
    
    
    $(".w-e-text").blur(function () {
        if(editor.txt.text().length == 0){
            editor.txt.html('<p>欢迎使用 <b>wangEditor</b> 富文本编辑器</p>');
            flag = true;
        }
    });

    $(".w-e-menu").click(function () {
        if (flag) {
            editor.txt.clear();
            flag = false;
        }
    });

    // 将富文本编辑器内容添加到表单的文本框中
    $(".w-e-text").bind('input propertychange', function () {
        $('#nr').val(editor.txt.html());
    });

</script>




