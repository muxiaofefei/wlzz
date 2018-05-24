<link rel="stylesheet" href="/css/style/usercenter.css">

<link href="/css/style/usertag.css" rel="stylesheet">


<body>

<div id="main">
    <div class="login-bg"></div>

    <div class="bg-other user-head-info">
        <div class="user-info clearfix">
            <?= \app\widgets\user\UserheadWidgets::widget();?>
        </div>

        <div class="wrap">

            <div class="slider" style="position: absolute; left: 24px; top: 0px;">

                <?= \app\widgets\user\UserleftWidgets::widget();?>
            </div>
            <div class="u-container">

                <div class="tagBox">
                    <div class="tagTiltle">
                        <h3>你的亮点~~~</h3>
                        <p>快把你的技能标签加在你的个人资料上吧</p>
                    </div>
                    <div class="tagCon clearfix" id="tagcon">

                        <?php if (!empty($data)): ?>
                            <?php $n = count($data); ?>
                            <?php for ($i = $n, $i >= 0; $i--;): ?>
                                <div class="tag">
                                    <em class="tagtxt">
                                        <?= $data[$i] ?>
                                    </em>
                                    <span class="move"></span>
                                    <a class="closetag">×</a>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>

                    </div>
                    <div class="addBox clearfix" id="addBox">
                        <input class="" type="text">
                        <button>添加</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
<script src="/js/jQueryDownload/jquery-3.1.1.min.js"></script>


<!-- 删除标签-->
<script>
    $("body").on("click",".closetag",function(){
        var tag = $.trim($(this).prev().prev().html());
        $.ajax({
            type: "GET",
            url: '/user/deletag.html?tag=' + tag,
        })
        $(this).parent().remove();
    });
</script>

<!--创建标签-->
<script type="text/javascript">
    var tagcon = $("tagcon");
    var addBox = $("addBox");
    var addBtn = addBox.children[1];
    var intxt = addBox.children[0];
    var divs = tagcon.children;

    function $(id){ return document.getElementById(id) }//$获取元素函数封装
    function crele(ele){ return document.createElement(ele); } //创建元素
    function adson(father,son1,son2,son3,clas1,clas2,clas3,clas4,con1,con2){
        father.appendChild(son1);
        father.appendChild(son2);
        father.appendChild(son3);
        father.className = clas1;
        son1.className = clas2;
        son2.className = clas3;
        son3.className = clas4;
        son1.innerHTML = con1;
        son3.innerHTML = con2;
    }
    //输入框聚焦和失焦的效果
    intxt.onfocus = function(){
        intxt.style.backgroundColor = "#fff";
    }
    intxt.onblur = function () {
        intxt.style.backgroundColor = "#e3e3e3";
    }
    //点击add按钮添加标签
    addBtn.onclick = function () {

        if (intxt.value.length > 8) {
            alert("标签最多输入八个文字");
        } else if (intxt.value != "") {
            $.ajax({
                type: "GET",
                url: '/user/addtag.html?tag=' + intxt.value,
                success: function (data) {
                    if (data == 1) {
                        var newdiv = crele("div");
                        var newem = crele("em");
                        var newspan = crele("span");
                        var newa = crele("a");
                        if (divs.length == 0) {//最新添加的标签在最前边
                            tagcon.appendChild(newdiv);
                        } else {
                            tagcon.insertBefore(newdiv, divs[0])
                        }
                        adson(newdiv, newem, newspan, newa, "tag", "tagtxt", "move", "closetag", intxt.value, "×")
                        intxt.value = "";

                    } else {
                        alert("标签已存在！请勿重复添加！");
                    }
                }
            })
        } else {
            alert("你还没有输入呢！");
        }
    };
</script>

