<style>
    .detail-right .recommend-info .aside-author {
        padding: 36px;
        word-break: break-all;
        text-align: center;
    }
    .detail-right .recommend-info .aside-author .author-img {
        width: 96px;
        margin: 0 92px;
    }
    .detail-right .recommend-info .aside-author .u-nick-warp {
        width: 100%;
        font-size: 16px;
        color: #4D555D;
        line-height: 16px;
        margin-bottom: 8px;
    }
    .detail-right .recommend-info .aside-author .user-job {
        display: block;
        font-size: 12px;
        color: #93999F;
        line-height: 12px;
        margin-bottom: 16px;
    }
    .detail-right .recommend-info .aside-author .user-desc {
        display: inline-block;
        font-size: 12px;
        color: #93999F;
        line-height: 24px;
    }
    .detail-right .recommend-info .btn-box {
        width: 100%;
        margin: 20px auto 0;
        text-align: center;
    }
    .detail-right .recommend-info .aside-author .user-bottor {
        display: block;
        margin-top: 17px;
    }


    .detail-right .recommend-info .aside-author .author-img img {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        margin-bottom: 16px;
    }

    .detail-right .recommend-info {
        background: #FFF;
        box-shadow: 0 4px 8px 0 rgba(7,17,27,.1);
        border-radius: 8px;
    }
    .moco-btn-red:hover, .moco-btn-red:focus, .moco-btn-red.focus, .moco-btn-red:active, .moco-btn-red.active {
        color: #fff;
        border-color: #c20a0a;
        background: #c20a0a;
        opacity: 1;
    }
    .detail-right .recommend-info .aside-author .user-bottor {
        display: block;
        margin-top: 17px;
    }
    .moco-btn-red {
        border-style: solid;
        border-width: 1px;
        cursor: pointer;
        -weibkit-transition: all .3s;
        -moz-transition: all .3s;
        transition: all .3s;
        color: #fff;
        background-color: #f20d0d;
        border-color: #f20d0d;
        opacity: 1;
    }
    .moco-ico-btn {
        position: relative;
        display: inline-block;
        margin-bottom: 0;
        text-align: center;
        vertical-align: middle;
        touch-action: manipulation;
        text-decoration: none;
        box-sizing: border-box;
        background-image: none;
        border-radius: 0;
        -webkit-appearance: none;
        white-space: nowrap;
        outline: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-style: solid;
        border-width: 1px;
        cursor: pointer;
        -weibkit-transition: all .3s;
        -moz-transition: all .3s;
        transition: all .3s;
        color: #545c63;
        background-color: transparent;
        border-color: #9199a1;
        opacity: 1;
        padding: 7px 16px;
        font-size: 14px;
        line-height: 1.42857143;
        border-radius: 18px;
    }
    .detail-right {
        width: 352px;
        position: absolute;
        top: 100px;
        right: 40px;
        z-index: 99;
    }
</style>


<div class="detail-right"><!-- 右侧start -->
    <div class="recommend-info">
        <!-- 作者信息 -->
        <div class="aside-author">
            <a href="#" class="l author-img" target="_blank">
                <img src="<?=$data['authorface']?>">
            </a>
            <p class="u-nick-warp">
                <a class="nick" href="#" target="_blank"><?=$data['authorname']?></a>
                <i class="user-icon great" title="认证作者"></i>
            </p>

            <span class="user-job">全栈工程师</span>
            <span class="user-desc">
				<?php if(isset($data['aboutme'])){echo $data['aboutme'];}else{echo '该用户还没设置签名哦~~~';}?>
<!--                微博：@慕课网，知乎：https://www.zhihu.com/org/mu-ke-wang-14/activities-->
			</span>
            <div class="btn-box clearfix">
                <a href="#" target="_blank" class="article-num r-bor">
                    <span><?=$data['newscount'] ?></span>篇文章
                </a>

            </div>
            <div class="user-bottor">

                <span class="moco-ico-btn moco-btn-red js-add-follow" data-uid="4321686" data-type="1"><i class="imv2-add"></i><em>关注</em></span>

                <span class="moco-ico-btn moco-btn-gray-l js-already-follow js-has-already" data-uid="4321686" data-type="2" style="display:none;"><i class="imv2-check"></i><em>已关注</em></span>

            </div>
        </div>

    </div>

</div>