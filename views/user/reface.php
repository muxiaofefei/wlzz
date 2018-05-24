


    <script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
    <script type="text/javascript">
        window.onload=function(){
            /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
            xiuxiu.embedSWF("altContent",5,"100%","500px");
            //修改为您自己的图片上传接口
            xiuxiu.setUploadURL("http://wlzz.com/user/refacecode.html");
            xiuxiu.setUploadType(2);
            xiuxiu.setUploadDataFieldName("Filedata");
            xiuxiu.onInit = function ()
            {
                xiuxiu.loadPhoto("");//修改为要处理的图片url
            }
            xiuxiu.onUploadResponse = function (data)
            {
                // alert("上传响应" + data); 可以开启调试
                // console.log(data);
                if(data) {
                    alert("头像设置成功！");
                    window.location.href="http://wlzz.com/user/usercenter.html";
                }
            }
        }
    </script>

    <div id="tabContent2">
        <div id="altContent"></div>
    </div>
