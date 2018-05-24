<?php

/*$to = "xxxxx@qq.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "s";
$headers = "From: $from";
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
*/

$username = $data['username'];
$token = $data['token'];
$email = $data['email'];

require_once 'QQMailer.php';

// 实例化 QQMailer
$mailer = new QQMailer(true);
// 添加附件
// $mailer->addFile('20130VL.jpg');
// 邮件标题
$title = '愿得一人心，白首不相离。';
// 邮件内容
$content = <<< EOF
亲爱的"$username"：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='http://wlzz.com/register/active.html?verify="$token"' target='_blank'>http://wlzz.com/register/active.html?verify="$token"</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- wlzz.com 敬上</p>
EOF;

// 发送QQ邮件
//$mailer->send($email, $title, $content);

?>
<b>感谢您的注册，快前往邮箱激活您的账号，来本站愉快的玩耍吧 ^0^</b>
<p><span id="time">10</span>秒后自动返回首页</p>

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
                $(location).prop('href', 'http://wlzz.com');
            }
        }
        setInterval(show, 1000);
    });
</script>