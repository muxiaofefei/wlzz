<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
use yii\widgets\LinkPager;
use yii\helpers\Url;


//计算发布时间距离现在多久
function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}

?>
<a href="<?= Url::to(['site/question'])?>">主页</a>-><a href="#">文章详情</a>
<br/>
<!--右侧作者详情-->
<?= \app\widgets\user\UserinfoWidgets::widget();?>

<link rel="stylesheet" href="/css/style/questioncont.css">
<link rel="stylesheet" href="/css/gototop/styles.css">

<div class="l wenda-main">
    <div class="qa-content-inner ">
        <div class="detail-q-title">
            <h1 class="detail-wenda-title"><?= $data['title'] ?></h1>

            <div class="wenda-intro-box">
                <div class="detail-user l">
                    <a href="#" class="author l">
                        <img src="<?= $data['authorface'] ?>">
                        <?= $data['authorname'] ?>
                    </a>
                </div>
                <div class="wenda-edit-box r">
                    <span><?= format_date($data['createtime'])?></span>
                    <?php if($data['authorid'] == \Yii::$app->session->get('userid')){?>
                        <a href="<?=Url::to(['site/editquestion','key'=>$_GET['key']])?>" class="detail-edit l">编辑</a>
                    <?php } ?>
                    <a href="javascript:;" class="detail-edit l">举报</a>
                    <a href="#add-com-tip"><span class="count-item l">回答<i id="comscount"><?=$data['comscount']?></></span></a>
                    <span class="count-item l">浏览<i> <?= $data['click'] ?></i></span>
                </div>
            </div>
            <div class="newscont"><?= $data['cont'] ?></div>
        </div>
    </div>
    <br>
    <br>
    <div class="wzzan">
        <?php
        if(isset($data['zan']) && $data['zan'] == 1){
            echo '<img width="80" height="80" src="/images/dzan.png" alt="">';
        }else{
            echo '<img width="80" height="80" src="/images/zan.png" alt="">';
        }
        ?>
        <span><?=$data['likecount']?></span>人赞
    </div>
    <br>
    <br>
    <?php
    if(!empty(\Yii::$app->session->get('userid'))){
    ?>
    <h4 class="add-com-tip" id="add-com-tip">添加评论</h4>
    <div class="df-ipt-wrap" id="comment">
        <div class="feeds-author">
            <img src="<?= \Yii::$app->session->get('userface') ?>" alt="用户头像">
        </div>
        <div class="df-text">
            <div class="textarea-wrap"><textarea id="addcom" placeholder="写下你的回复..."></textarea></div>
        </div>
        <button id="js-submit" class="comment-btn r">评论（Ctrl+Enter）</button>
    </div>
    <?php
    }
    ?>

    <div id="js-feedback-list">
        <?php if (isset($data['coms'])): ?>
            <?php foreach ($data['coms'] as $k => $v):?>

                <div class="comment-box clearfix">
                    <div class="comment clearfix">
                        <div class="feed-author l">
                            <a href="<?=$v['uid']?>">
                                <img src="<?=$v['userface']?>" width="48">
                                <span class="com-floor"><b class="loucen"><?=$v['zlc']?></b>楼</span>
                            </a>
                        </div>
                        <div class="feed-list-content">
                            <a class="nick from-user" href="<?=$v['uid']?>" target="_blank"><?= $v['username'] ?></a>
                            <input type="hidden" class="fromuid" value="<?=$v['uid']?>" zhlid = "<?=$v['_id']?>">
                            <span class="feed-list-times"> <?= format_date($v['createtime']);?></span>
                            <p><?=$v['cont']?></p>
                            <div class="comment-footer clearfix">
                                <?php
                                if(isset($v['zan']) && $v['zan'] == 1){
                                    echo ' <span class="agree-with l zzan" >';
                                }else{
                                    echo ' <span class="agree-with l" >';
                                }
                                ?>
                                    <b class="imv2-thumb_up" title="赞同"><?=$v['likecount']?></b><em>赞</em>
                                </span>
                                <span class="reply-btn">回复</span>
                                <?php if($v['uid'] == \Yii::$app->session->get('userid') || $data['author'] == \Yii::$app->session->get('userid')):?>
                                <span class="delcoms">删除</span>
                                <?php endif;?>
                                <span class="report-btn js-tip-off tipoff " style="display: block;">举报</span>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($v['zjcoms'])):?>
                    <?php foreach ($v['zjcoms'] as $kk => $vv):?>
                        <div class="reply-box" zl="<?=$zl?>">
                            <div class="comment clearfix">
                                <div class="feed-author l">
                                    <a href="#">
                                        <img src="<?=$vv['userface']?>" width="48">
                                    </a>
                                </div>
                                <div class="feed-list-content">
                                    <span class="feed-list-time"><?= format_date($vv['createtime']);?></span>
                                    <input type="hidden" class="fromuid" value="<?=$vv['uid']?>" zhlid = "<?=$v['_id']?>">
                                    <a href="/u/2967026/articles" class="from-user"><?=$vv['username']?></a>
                                    回复
                                    <a href="/u/4539127/articles" class="to-user"><?=$vv['fusername']?></a>
                                    ：
                                    <p><?=$vv['cont']?></p>
                                    <div class="comment-footer clearfix">
                                        <span class="reply-btn reply-btns ">回复</span>
                                        <?php if($vv['uid'] == \Yii::$app->session->get('userid') || $data['author'] == \Yii::$app->session->get('userid')):?>
                                            <span class="delcomsz" zlid="<?=$vv['_id']?>">删除</span>
                                        <?php endif;?>
                                        <span class="report-btn js-tip-off tipoff ">举报</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                    <div class="release-reply clearfix" style="display: none;">
                        <a href="javascript:void(0)" class="user-head">
                            <img src="<?= \Yii::$app->session->get('userface') ?>">
                        </a>
                        <div class="replay-con l">
                            <div class="textarea-wrap">
                                <textarea class="zjhf" placeholder="写下你的回复..."></textarea>
                                <input type="hidden" class="fromuid" value="">
                            </div>
                            <p class="errtip"></p>
                            <div class="reply-ctrl clearfix">
                                <div class="captcha-verify-box js-reply-verify-box hide"></div>
                                <div class="btn-wrap">
                                    <div class="cancel-btn">取消</div>
                                    <div class="release-reply-btn">回复</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="zjpllb">
                        <?php
                        $n = ceil($v['count'] / 5);
                        if ($n > 1) {

                            echo '1/<span class="zjcount">'.$n.'</span>　';
                            for ($i = 1; $i <= $n; $i++) {
                                echo '<a href="javascript:void(0)" class="zjfy" pg="'.$i.'">'.$i.'</a>';
                                if($i == 3){break;}
                            }
                            if($n>3){
                            echo '...';
                            }
                        }

                        ?>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endforeach; ?>
        <?php endif;?>

    </div>

    <?php
    echo LinkPager::widget(['pagination' => $pages,
        'firstPageLabel'=>'首页',
        'lastPageLabel'=>'末页',
        'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页', 'options' => ['class' => 'pagination']]);
    ?>

    <button class="gototop"><span>返回顶部</span></button>


</div>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>
<?php
use app\assets\AppAsset;
AppAsset::register($this);
AppAsset::addScript($this,'@web/js/gototop/jquery.gototop.min.js');
?>

<!--返回顶部-->
<script type="text/javascript">
    $(function() {
        $(".gototop").gototop({
            position: 0,
            duration: 1250,
            visibleAt: 300
        });
    });
</script>

<script>
    // 计算发布时间距离现在多久
    function getDateDiff (dateStr) {
        var publishTime = dateStr,
            d_seconds,
            d_minutes,
            d_hours,
            d_days,
            timeNow = parseInt(new Date().getTime()/1000),
            d,

            date = new Date(publishTime*1000),
            Y = date.getFullYear(),
            M = date.getMonth() + 1,
            D = date.getDate(),
            H = date.getHours(),
            m = date.getMinutes(),
            s = date.getSeconds();
        //小于10的在前面补0
        if (M < 10) {
            M = '0' + M;
        }
        if (D < 10) {
            D = '0' + D;
        }
        if (H < 10) {
            H = '0' + H;
        }
        if (m < 10) {
            m = '0' + m;
        }
        if (s < 10) {
            s = '0' + s;
        }

        d = timeNow - publishTime;
        d_days = parseInt(d/86400);
        d_hours = parseInt(d/3600);
        d_minutes = parseInt(d/60);
        d_seconds = parseInt(d);

        if(d_days > 0 && d_days < 3){
            return d_days + '天前';
        }else if(d_days <= 0 && d_hours > 0){
            return d_hours + '小时前';
        }else if(d_hours <= 0 && d_minutes > 0){
            return d_minutes + '分钟前';
        }else if (d_seconds < 60) {
            if (d_seconds <= 0) {
                return '刚刚发表';
            }else {
                return d_seconds + '秒前';
            }
        }else if (d_days >= 3 && d_days < 30){
            return M + '-' + D + '&nbsp;' + H + ':' + m;
        }else if (d_days >= 30) {
            return Y + '-' + M + '-' + D + '&nbsp;' + H + ':' + m;
        }
    }
</script>

<script>

    // 初始化主评论翻页加入锚点定位
    $(function(){
        var zlfy = $('.pagination').find('li');
        for (var i=0;i<zlfy.length;i++){
            var yurl = $('.pagination').find('li').eq(i).find('a').attr('href');
            var xurl = yurl + '#add-com-tip';
            $('.pagination').find('li').eq(i).find('a').attr('href',xurl)
        }
    });

    // 文章点赞
    $("body").on("click",".wzzan", function () {
        suid='<?=Yii::$app->session->get('userid')?>';
        if(suid.length != 0){
            var src = $(this).children('img').attr('src');
            var dz;
            if(src == '/images/zan.png'){
                dz = true;
                $(this).children('img').attr('src','/images/dzan.png');
                var zs = parseInt($(this).children('span').html())+1;
                $(this).children('span').html(zs);
            }else{
                dz = false;
                $(this).children('img').attr('src','/images/zan.png');
                var zs = parseInt($(this).children('span').html())-1;
                $(this).children('span').html(zs);
            }

            $.ajax({
                url: '/site/dzwz.html?uid=<?=\Yii::$app->session->get('userid')?>&key=<?=$data['_id']?>&dz='+dz,
                type: 'GET',
                success: function (data) {

                }
            })
        }else{
            alert('登陆后才能点赞哦！');
        }

    })


    // 评论点赞
    $("body").on("click",".agree-with", function () {
        var flag = $(this).attr('class');
        var zhlid = $(this).parents('.feed-list-content').children('.fromuid').attr('zhlid');

        if (flag == 'agree-with l') {
            dz = true;
            $(this).attr('class', 'agree-with l zzan');
            var zs = parseInt($(this).children('b').html()) + 1;
            $(this).children('b').html(zs);
        }else {
            dz = false;
            $(this).attr('class', 'agree-with l');
            var zs = parseInt($(this).children('b').html()) - 1;
            $(this).children('b').html(zs);
        }


        $.ajax({
            url: '/site/dzpl.html?uid=<?=\Yii::$app->session->get('userid')?>&key='+ zhlid +'&dz='+dz,
            type: 'GET',
            success: function (data) {

            }
        })


    })

    //子评论列表翻页
    $("body").on("click",".zjfy", function () {
        var page = $(this).attr('pg');

        var zhlid = $(this).parents('.comment-box').find('.fromuid').attr('zhlid');

        $(this).parents('.comment-box').children('.reply-box').remove();
        $(this).parents('.comment-box').children('.release-reply').css('display','none');

        function load_val2() {
            var zjdata;
            $.ajax({
                url: '/site/zjfy.html?key=' + zhlid+'&page='+page,
                async: false,//这里选择异步为false，那么这个程序执行到这里的时候会暂停，等待
                type: 'GET',
                success: function (data) {
                    zjdata =data;
                }
            })
            return zjdata;
        }

        var zjdata = load_val2(); //拿ajax返回的数据
        var zjdata = JSON.parse(zjdata);    //将json数据转化成数组
        var objKeys = Object.keys(zjdata);  //返回对象的属性值列表
        var datalength = objKeys.length;
        var result=''
        if(datalength>0){
            for (i = 0; i < datalength; i++) {

                result =
                    '  <div class="reply-box">\n' +
                    '                        <div class="comment clearfix">\n' +
                    '                            <div class="feed-author l">\n' +
                    '                                <a href="' + zjdata[objKeys[i]]['uid'] + '">\n' +
                    '                                    <img src="' + zjdata[objKeys[i]]['userface'] + '" width="48">\n' +
                    '                                </a>\n' +
                    '                            </div>\n' +
                    '                            <div class="feed-list-content">\n' +
                    '                                <span class="feed-list-time">'+getDateDiff(zjdata[objKeys[i]]['createtime'])+' </span>\n' +
                    '                                <input type="hidden" class="fromuid" value="'+zjdata[objKeys[i]]['uid']+'"  zhlid = "' + zhlid + '">' +
                    '                                <a href="' + zjdata[objKeys[i]]['uid'] + '" class="from-user">' + zjdata[objKeys[i]]['username'] + '</a>\n' +
                    '                                回复\n' +
                    '                                <a href="/u/4539127/articles" class="to-user">' + zjdata[objKeys[i]]['fusername'] + '</a>\n' +
                    '                                ：\n' +
                    '                                <p>' + zjdata[objKeys[i]]['cont'] + '</p>\n' +
                    '                                <div class="comment-footer clearfix">\n' +
                    '                                    <span class="reply-btn reply-btns ">回复</span>\n' +
                    '                                    <span class="delcomsz" zlid="'+objKeys[i]+'">删除</span>' +
                    '                                    <span class="report-btn js-tip-off tipoff ">举报</span>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>';


                $(this).parents('.comment-box').children('.release-reply').before(result);
            }
        }

        var zjcount = $(this).parents('.comment-box').find('.zjcount').html();

        var lpg = parseInt(page) - 2;
        var rpg = parseInt(page) + 2;

        if(rpg>zjcount){rpg=zjcount}
        if(lpg<=0){lpg=1}

        var ym = page+'/<span class="zjcount">'+zjcount+'</span>　';
        var zjym = '';

        for (i=lpg;i<=rpg;i++){
            zjym += '<a href="javascript:void(0)" class="zjfy" pg="'+i+'">'+i+'</a>';
        }

        if(page==1 && zjcount>3){
            zjym += '...';
        }

        if(page<4 && zjcount>4){
            zjym += '...';
        }

        if(page>=4){
            ym+='...';
        }

        zym = ym+zjym
        if(page>=4 && page<=zjcount-3){
            zym+='...';
        }

        $(this).parents('.comment-box').children('.zjpllb').html(zym);

    })

    //删除子评论
    $("body").on("click", ".delcomsz", function () {
        if (confirm('确实要删除该内容吗?')) {
            $(this).parents('.reply-box').css('display', 'none');
            var zlid = $(this).attr('zlid');
            $.ajax({
                url: '/site/delcomsz.html?key=' + zlid,
                type: 'GET',
                success: function (data) {
                    alert('删除成功');
                }
            })
        }
    });

    //删除主评论
    $("body").on("click", ".delcoms", function () {
        if (confirm('确实要删除该内容吗?确认后子楼层内容的也会删除的哦！')) {
            var comscount = parseInt($('#comscount').html()) - 1;
            $('#comscount').html(comscount);

            $(this).parents('.comment-box').css('display', 'none');         //隐藏评论窗口
            var zhlid = $(this).parents('.feed-list-content').find('.fromuid').attr('zhlid'); //主楼层id
            $.ajax({
                url: '/site/delcoms.html?key=' + zhlid,
                type: 'GET',
                success: function (data) {
                    alert('删除成功');
                }
            })
        }
    });


    //评论回复点击事件
    $("body").on("click",".reply-btn",function(){
        suid='<?=Yii::$app->session->get('userid')?>';
        if(suid.length != 0){
            $(this).parents('.comment-box').children('.release-reply').css('display','block');

            var fromuser = $(this).parents('.feed-list-content').children('.from-user').html(); //回复对象的用户昵称
            var fromuid = $(this).parents('.feed-list-content').children('.fromuid').val(); //回复对象的用户id
            var zhlid = $(this).parents('.feed-list-content').children('.fromuid').attr('zhlid'); //主楼评论的id

            //回复框默认指向
            $(this).parents('.comment-box').children('.release-reply').find('textarea').attr('placeholder','回复'+fromuser).val('').focus(); //填充内容获得焦点
            $(this).parents('.comment-box').children('.release-reply').find('.fromuid').val(fromuid).attr('zhlid',zhlid);
        }else {
            alert('登录后才能回复哦！');
        }

    })


//发布主评论
$("body").on("click",".comment-btn",function(){
    var com = $('#addcom').val();
    var comscount = parseInt($('#comscount').html()) + 1;
    $('#comscount').html(comscount);

    var zlc = $(this).parents('.df-ipt-wrap').next('#js-feedback-list').find('.loucen').first().html(); //主评论的楼层
    if(zlc == undefined){
        zlc = 1;
    }else{
        zlc++;
    }

    if(com.length == 0){
        alert('评论不能为空！');
    }else{

        $.ajax({
            url: '/site/addcom.html',
            type: 'POST',
            data: {
                'com':com,
                'userid':'<?=\Yii::$app->session->get('userid')?>',
                'newid':'<?=$data['_id']?>',
            },

            success: function (data) {

                var data = JSON.parse(data);

                var result =

                    '<div class="comment-box clearfix">'+

                        '<div class="comment clearfix">'+
                            '<div class="feed-author l">'+
                                '<a href="/u/4539127/articles">'+
                                    '<img src="'+'<?= \Yii::$app->session->get('userface') ?>'+'" width="48">'+
                                    '<span class="com-floor"><b class="loucen">'+data['zlc']+'</b>楼</span>'+
                                '</a>'+
                            '</div>'+

                            '<div class="feed-list-content">'+
                                '<input type="hidden" class="fromuid" value="'+'<?= \Yii::$app->session->get('userid') ?>'+'" zhlid = "'+data['_id'].$id+'">'+
                                '<a class="nick from-user" href="/u/4539127/articles" target="_blank">'+'<?= \Yii::$app->session->get('username') ?>'+'</a>'+
                                '<span class="feed-list-times"> 1秒前</span>'+
                                '<p>'+com+'</p>'+
                                '<div class="comment-footer clearfix">'+
                                    '<span class="agree-with l" >'+
                                        '<b class="imv2-thumb_up" title="赞同">1</b><em>赞</em>'+
                                    '</span>'+
                                    '<span class="reply-btn">回复</span>'+
                                    '<span class="delcoms">删除</span>'+
                                    '<span class="report-btn js-tip-off tipoff " style="display: block;">举报</span>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+

                        '<div class="release-reply clearfix" style="display: none;">'+
                            '<a href="javascript:void(0)" class="user-head">' +
                                '<img src="'+'<?= \Yii::$app->session->get('userface') ?>'+'">' +
                            '</a>'+
                            '<div class="replay-con l">'+
                                '<div class="textarea-wrap">' +
                                    '<textarea class="zjhf" placeholder="写下你的回复..."></textarea>' +
                                    '<input type="hidden" class="fromuid" value="">'+
                                '</div>'+
                                '<p class="errtip"></p>'+

                                '<div class="reply-ctrl clearfix">'+
                                    '<div class="captcha-verify-box js-reply-verify-box hide"></div>' +
                                    '<div class="btn-wrap">' +
                                        '<div class="cancel-btn">取消</div>' +
                                        '<div class="release-reply-btn">回复</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>'+

                    '</div>';
                $('#js-feedback-list').before(result);
                $('#addcom').val('');
                alert('评论成功！');
            }
        });
    }

})

    //发布子评论
    $("body").on("click",".release-reply-btn",function(){

        var zhlid = $(this).parents('.comment-box').children('.release-reply').find('.fromuid').attr('zhlid'); //主楼评论id

        var fromuid = $(this).parents('.comment-box').children('.release-reply').find('.fromuid').val();
        var fromuser = $(this).parents('.comment-box').children('.release-reply').find('textarea').attr('placeholder');
        fromuser = fromuser.substring(2);//截取用户名

        var zjcoms = $(this).parents('.comment-box').children('.release-reply').find('textarea').val();
        if(zjcoms.length == 0){
            alert('评论不能为空哦！');
        }else{

            function load_val2() {
                var zicomsid;
                $.ajax({
                    url: '/site/addcomszj.html',
                    async: false,//这里选择异步为false，那么这个程序执行到这里的时候会暂停，等待
                    type: 'POST',
                    data: {
                        'zjcoms': zjcoms,
                        'userid': '<?=\Yii::$app->session->get('userid')?>',
                        'newid': '<?=$data['_id']?>',
                        'fromuid': fromuid,
                        'zhlid':zhlid,
                    },
                    success: function (data) {
                        zicomsid = data;
                        alert('回复成功！');
                    }
                });
                return zicomsid;
            }

            var zicomsid = load_val2(); //拿去ajax返回的子评论id值

            result =
                '  <div class="reply-box">\n' +
                '                        <div class="comment clearfix">\n' +
                '                            <div class="feed-author l">\n' +
                '                                <a href="' + '<?= \Yii::$app->session->get('userid') ?>' + '">\n' +
                '                                    <img src="' + '<?= \Yii::$app->session->get('userface') ?>' + '" width="48">\n' +
                '                                </a>\n' +
                '                            </div>\n' +
                '                            <div class="feed-list-content">\n' +
                '                                <span class="feed-list-time"> 1秒前</span>\n' +
                '                                <input type="hidden" class="fromuid" value="'+'<?= \Yii::$app->session->get('userid') ?>'+'"  zhlid = "' + zhlid + '">' +
                '                                <a href="' + '<?= \Yii::$app->session->get('userid') ?>' + '" class="from-user">' + '<?= \Yii::$app->session->get('username') ?>' + '</a>\n' +
                '                                回复\n' +
                '                                <a href="/u/4539127/articles" class="to-user">' + fromuser + '</a>\n' +
                '                                ：\n' +
                '                                <p>' + zjcoms + '</p>\n' +
                '                                <div class="comment-footer clearfix">\n' +
                '                                    <span class="reply-btn reply-btns ">回复</span>\n' +
                '                                    <span class="delcomsz" zlid="'+zicomsid+'">删除</span>' +
                '                                    <span class="report-btn js-tip-off tipoff ">举报</span>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '                    </div>';
            // 插入评论并隐藏输入框
            $(this).parents('.comment-box').children('.release-reply').before(result).css('display','none');

        }

    })


    //关闭回复框
    $("body").on("click",".cancel-btn",function(){
        $(this).parents('.comment-box').children('.release-reply').css('display','none');
    })


</script>
<script type="text/javascript" src="/js/canvas-nest.min.js"></script>
