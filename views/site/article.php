<?php
use yii\helpers\Url;
use yii\bootstrap\Alert;

date_default_timezone_set('Asia/Shanghai');

?>

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


<link rel="stylesheet" href="/css/style/question.css">
<link rel="stylesheet" href="/css/gototop/styles.css">

<div class="questionlist">
    <?php
    foreach ($data as $k=>$v):
        ?>
        <div id="newslist" class="article-lwrap clearfix">
            <?php if(!isset($v['newscover'])){ $v['newscover'] = '/public/newscover/default/default.jpg' ;}?>
            <div class="imgCon l">
                <img src="<?=$v['newscover']?>">
            </div>
            <div class="list-content l">
                <a href="<?=Url::to(['site/questioncont','key'=>$k])?>" target="_blank" class="title"><p><?=$v['title']?></p></a>
                <div class="list-bottom clearfix">
                    <label class="moco-label label l"><a href="" target="_blank"><?=$v['authorname']?></a></label>

                    <div class="browseNum l">
                        <i class="imv2-visibility"></i>
                        <span><?=$v['click']?></span>
                    </div>

                    <?php foreach ($v['tags'] as $k1=>$v1):?>
                        <div class="skill l clearfix">
                            <a href="<?= Url::to(['site/article','tag'=>$v1])?>" target="_blank"><span><?php if(strlen($v1) > 18){echo substr($v1,0,18).'...';}else{echo $v1;}?></span></a>
                        </div>
                    <?php endforeach;?>

                    <div class="createTime r">
                        <?= date('y-m-d H:i',$v['createtime'])?>
                    </div>
                </div>
            </div>
        </div>

        <button class="gototop"><span>返回顶部</span></button>

    <?php
    endforeach;
    ?>
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
<!--
<script>
    // 时间戳转换日期
    function timestampToTime(timestamp,type = 0) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear();
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
        D = (date.getDate() < 10 ? '0'+(date.getDate()) : date.getDate());
        h = (date.getHours() < 10 ? '0'+(date.getHours()) : date.getHours());
        m = (date.getMinutes() < 10 ? '0'+(date.getMinutes()) : date.getMinutes());
        s = (date.getSeconds() < 10 ? '0'+(date.getSeconds()) : date.getSeconds());
        if(type ==0){
            return Y+'-'+M+'-'+D+' '+h+':'+m+':'+s;
        }else {
            Y = String(Y);  //转换为字符串类型
            return Y.substring(2,4)+'-'+M+'-'+D+' '+h+':'+m;
        }
    }

    // 滚动条到底部触发事件是否开启
    var ajaxmore = true;
    var page = 1;
    var pagesize = 20;

    $(document).ready(function () {
        $(window).scroll(function () {

            var scrolltop = parseInt($(document).scrollTop());  //滚动高度
            var wheight = parseInt($(window).height()); //窗口滚动条高度
            var dheight = parseInt($(document).height());   //文档总高度

            if (dheight - (scrolltop + wheight) < 300 && ajaxmore) {
                ajaxmore = false;
                page++;

                $.ajax({
                    type: "GET",
                    url: '/site/morequestion.html?page=' + page + '&pagesize=' + pagesize,
                    success: function (data) {

                        var data = JSON.parse(data);    //将json数据转化成数组
                        var objKeys = Object.keys(data);  //返回对象的属性值列表
                        var datalength = objKeys.length;
                        var result='';
                        if (datalength > 0) {
                            for (i = 0; i < datalength; i++) {

                                //封面
                                var newcower='/public/newscover/default/default.jpg';
                                if(data[objKeys[i]]['newscover']){
                                    newcower = data[objKeys[i]]['newscover'];
                                }

                                //标签
                                var tagdiv = '';
                                if(data[objKeys[i]]['tags'].length>0){
                                    for (j=0;j<data[objKeys[i]]['tags'].length;j++){
                                        var taglink = '/site/article.html?tag='+data[objKeys[i]]['tags'][j];

                                        var tag = data[objKeys[i]]['tags'][j];
                                        if(tag.length > 6){
                                            tag = tag.substring(0,6)+'...';
                                        }
                                        tagdiv +=
                                            '<div class="skill l clearfix">'+
                                            '<a href="'+taglink+'" target="_blank"><span>'+tag+'</span></a>'+
                                            '</div>'
                                    }
                                }

                                var newslink = '/site/questioncont.html?key='+objKeys[i];

                                result =
                                    '<div id="newslist" class="article-lwrap clearfix">' +
                                    '<div class="imgCon l">' +
                                    '<img src="'+newcower+'">' +
                                    '</div>' +
                                    '<div class="list-content l">'+
                                    '<a href="'+newslink+'" target="_blank" class="title"><p>'+data[objKeys[i]]['title']+'</p></a>'+

                                    '<div class="list-bottom clearfix">'+
                                    '<label class="moco-label label l"><a href="" target="_blank">'+data[objKeys[i]]['authorname']+'</a></label>'+
                                    '<div class="browseNum l">'+
                                    ' <i class="imv2-visibility"></i>'+
                                    '<span>'+data[objKeys[i]]['click']+'</span>'+
                                    '</div>'
                                    +tagdiv +
                                    '<div class="createTime r">'+
                                    timestampToTime(data[objKeys[i]]['createtime'],1)+
                                    '</div>'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>';

                                $('.questionlist').append(result);

                            }

                        } else {
                            // alert(2);
                        }

                        ajaxmore = true;
                    }
                })

            }

        });
    });
</script>
-->