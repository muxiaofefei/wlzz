<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<!--    //js-->
    <script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
    <script type="text/javascript">
        window.onload=function(){
            /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
            xiuxiu.embedSWF("altContent",5,"100%","100%");
            //修改为您自己的图片上传接口
            xiuxiu.setUploadURL("http://wlzz.com/user/reface.html");
            xiuxiu.setUploadType(2);
            xiuxiu.setUploadDataFieldName("Filedata");
            xiuxiu.onInit = function ()
            {
                xiuxiu.loadPhoto("");//修改为要处理的图片url
            }
            xiuxiu.onUploadResponse = function (data)
            {
                // alert("上传响应" + data); 可以开启调试
                console.log(data);
                if(data) {
                    if(confirm("头像已经成功保存！") == true){
                        window.location.href="http://wlzz.com/user/usercenter.html";
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    alert(data);
                }
            }
        }
    </script>

    <div id="tabContent2">
        <div id="altContent"></div>
    </div>



<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->fileInput() ?>

    <button>Submit</button>


<!--    <img src="/public/uploads/wz/20180305211546231.jpg" alt="">-->



<?php ActiveForm::end() ?>