<?php

global $rpROOT, $rpCfg, $lpApp, $msg;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->title = "购买";
?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#pay"><i class="icon-chevron-right"></i> 购买</a></li>
<li><a href="#position"><i class="icon-chevron-right"></i> 机房列表</a></li>
<li><a href="#agreement"><i class="icon-chevron-right"></i> 政策和约定</a></li>
<? $tmp->sidenav = lpTemplate::endBlock(); ?>

<section id="pay">
    <header>购买</header>
    <? if(!rpAuth::login()): ?>
        <div class="alert alert-block alert-error fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4 class="alert-heading">注意</h4>

            <p>如果你还没在本站注册过帐号，请先注册帐号再购买！.</p>

            <p>
                <a class="btn btn-info btn-inline" href="/user/signup/">注册帐号</a>
            </p>
        </div>
    <? else: ?>
        <?php
        $user = rpApp::q("user")->where(["uname" => rpAuth::uname()])->top();
        ?>
        <? if($user["type"] == rpUser::NO): ?>
            <div class="alert alert-block alert-success fade in">
                <h4 class="alert-heading">提示</h4>

                <p>你还没有购买RP主机，请在下方选择一种方式购买：</p>

                <p>PS：如果你已经在淘宝付款成功，请耐心等待开通，或通过 <code><i class="icon-envelope"></i>m@jybox.net</code> 来诅咒客服.</p>
            </div>
        <? else: ?>
            <div class="alert alert-block alert-success fade in">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading">提示</h4>

                <p>你已经购买过RP主机了，不过你还可以续费：</p>
            </div>
        <? endif; ?>
    <? endif;?>
    <div class="row-fluid">
        <div class="span4">
            <h3>试用版</h3>

            <p>免费</p>

            <p>
                <a class="btn btn-success" href="/pay/free/">填写申请</a>
            </p>
        </div>
        <div class="span4">
            <h3>标准版</h3>

            <p>每月8元，每季度19元.</p>

            <p>
                <a class="btn btn-success" href="<?= $rpCfg["Pay"]["std"]; ?>">去淘宝付款</a>
            </p>
        </div>
        <div class="span4">
            <h3>额外技术支持版</h3>

            <p>每月15元，每季度35元</p>

            <p>
                <a class="btn btn-success" href="<?= $rpCfg["Pay"]["ext"]; ?>">去淘宝付款</a>
            </p>
        </div>
    </div>
    <hr/>
    <p>
        您直接在淘宝拍下对应商品即可，并记得<b>在备注中填写您的用户名 <span style="color: red;"><?= rpAuth::uname();?></span></b>，你还可以在下方的机房列表中选择你想要的机房.
    </p>
</section>

<section id="position">
    <div class="page-header">
        <h1>机房列表</h1>
    </div>
    <?php lpTemplate::outputFile("{$rpROOT}/template/node-list.php");?>
</section>

<? lpTemplate::outputFile(lpLocale::i()->file("template/agreement.php")); ?>

<? $tmp->output(); ?>

