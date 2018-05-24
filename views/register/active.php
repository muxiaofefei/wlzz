
<?php if($state):?>
    <p>激活成功</p>
    <p><span id="time">10</span>秒后自动返回首页</p>
<?php else:?>
    <p>哎呀，激活出现了点小问题，请联系管理员</p>
    <p>管理员邮箱：1277475536@qq.com</p>
<?php endif;?>


<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>

<script>

// jQuery倒计时10秒页面跳转
$(function() {
    var sj = parseInt($('#time').html());

    function show() {
        sj--;
        $('#time').html(sj);
        if (sj == 0) {
            $(location).prop('href', 'http://wlzz.com/site/question.html');
        }
    }

    setInterval(show, 1000);

});

</script>