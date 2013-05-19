<?php

global $rpROOT, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");

$base['title'] = "填写试用申请";
?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#request"><i class="icon-chevron-right"></i> 填写试用申请</a></li>
<li><a href="#limits"><i class="icon-chevron-right"></i> 试用帐号限制</a></li>
<li><a href="#rule"><i class="icon-chevron-right"></i> 审核原则</a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    #request textarea {
        width: 98%;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type="text/javascript">
    $($(function () {
        defaultValue = $("#content").val();
    }));
    $(document).ready(function () {
        $("#form").submit(function () {
            if (defaultValue == $("#content").val()) {
                alert("你根本没填啊亲！");
                return false;
            }
        });
    });
</script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>


<section id="request">
    <header>填写试用申请</header>
    <? if(!rpAuth::login()): ?>
        <div class="alert alert-block alert-error fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4 class="alert-heading">注意</h4>

            <p>如果你还没在本站注册过帐号，请先注册帐号再填写申请！.</p>

            <p>
                <a class="btn btn-info" href="/user/signup/">注册帐号</a>
            </p>
        </div>
    <? else: ?>
        <?php
        $user = rpApp::q("user")->where(["uname" => rpAuth::uname()])->top();
        ?>
        <? if($user["type"] == rpUser::NO): ?>
            <div class="alert alert-block alert-success fade in">
                <h4 class="alert-heading">提示</h4>

                <p>你还没有开通RP主机，请填写申请以获得试用，或直接 <a class="btn btn-success" href="/pay/">购买</a></p>

                <p>如果你已经发送了申请，请耐心等待回复(你注册时填写的邮箱)，一般会在24小时内回复，无论申请是否通过.</p>
            </div>
        <? elseif($user["type"] == rpUser::FREE): ?>
            <div class="alert alert-block alert-success fade in">
                <h4 class="alert-heading">提示</h4>

                <p>你已经获得RP主机试用资格了，不过你还可以继续填写申请以获得延期</p>
            </div>
        <? else: ?>
            <div class="alert alert-block alert-success fade in">
                <h4 class="alert-heading">提示</h4>

                <p>你在开玩笑吧？你都已经购买付费版了，还申请个毛啊</p>
            </div>
        <? endif; ?>
    <? endif;?>
    <? if(rpAuth::login() && ($user["type"] == rpUser::NO || $user["type"] == rpUser::FREE)): ?>
        <form class="form-horizontal" id="form" method="post">
            <textarea id="content" name="content" rows="18"><?= $rpL["pay-free.tmp.request"];?></textarea><br/>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">提交申请</button>
            </div>
        </form>
    <? endif;?>
</section>

<section id="limits">
    <header>试用帐号限制</header>
    <p>
        CPU时间限制(按天)：500秒(相当于0.6%)<br/>
        最小内存保证：10M<br/>
        内存竞争系数：0.4(与付费用户竞争内存时的系数)<br/>
        硬盘限制：300M<br/>
        流量限制(按天)：300M<br/>
        流量限制(按月)：3G<br/><br/>

        不提供客服支持，不担保数据的安全，可能随时被删除(尽可能做到事先通知).
    </p>
</section>

<section id="rule">
    <header>免费版审核原则</header>
    <ul>
        <li>用途符合RP主机的<a href="/#agreement">政策和约定</a>, 没有擦边内容</li>
        <li>能够为互联网创造价值(如写博客), 而不是单纯利己</li>
        <li>确实有困难无法购买付费版</li>
    </ul>
</section>

<? $base->output(); ?>
