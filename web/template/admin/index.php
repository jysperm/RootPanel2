<?php

$base = new lpTemplate(rpROOT . "/template/base.php");

$base['title'] = "管理员面板";

$db = lpFactory::get("PDO");

$commonAct = function($uname)
{
    global $lpCfg;
    $cookieName = $lpCfg["lpTrackAuth"]["CookieName"];
    $myUName = rpAuth::uname();
    $getLoginas = "?{$cookieName["user"]}={$myUName}&{$cookieName["passwd"]}={$_COOKIE[$cookieName["passwd"]]}&rp_changeuname={$uname}";
    $getLog = "&{$getLoginas}&goUrl=/panel/logs/";

    lpTemplate::beginBlock(); ?>
    <li class="divider"></li>
    <li><a href="#" onclick="newTK('<?= $uname;?>');">创建工单</a></li>
    <li><a href="/user/set-cookie/<?= $getLog;?> ">日志</a></li>
    <li><a href="/user/set-cookie/<?= $getLoginas;?> ">登录为</a></li>
    <li><a href="#" onclick="getPasswd('<?= $uname;?>');">找回密码</a></li>
    <? return lpTemplate::endBlock();
};

?>

<? lpTemplate::beginBlock();?>

<li class="active"><a  href="#section-index"><i class="icon-chevron-right"></i> 概述</a></li>
<li><a href="#section-users"><i class="icon-chevron-right"></i> 用户管理</a></li>
<li><a href="/admin/logs/"><i class="icon-chevron-right"></i> 日志</a></li>
<li><a href="/admin/ticket/"><i class="icon-share"></i> 工单</a></li>

<? $base['sidenav'] = lpTemplate::endBlock();?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    .input-xxlarge {
        width: 250px;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type='text/javascript' src='/script/admin.js'></script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

<div class="modal hide" id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialogLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="dialogLabel" class="dialog-title"></h3>
    </div>
    <div class="modal-body dialog-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
        <button class="btn btn-primary dialog-ok">保存</button>
    </div>
</div>

<section id="section-index">
    <header>概述</header>
</section>

<section id="section-users">
    <header>用户管理</header>
    <h4>未开通</h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>用户(UA)</th><th>工单</th><th>Email(QQ)</th><th>最后登录</th><th></th>
        </tr>
        </thead>
        <tbody>
            <? foreach(rpUserModel::select(["type" => "no"]) as $user): ?>
            <? if((new rpUserModel($user['id']))->isAdmin()) continue; ?>
                <tr>
                    <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                    <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => "ticket.status.open"]) ?></a></td>
                    <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                    <td><span title="<?= gmdate("Y.m.d H:i:s", $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                                操作
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick="enableUser('<?= $user['uname'];?>', 'std');">开通为标准付费版</a></li>
                                <li><a href="#" onclick="enableUser('<?= $user['uname'];?>', 'ext');">开通为额外技术支持版</a></li>
                                <li><a href="#" onclick="enableUser('<?= $user['uname'];?>', 'free');">开通为免费试用版</a></li>
                                <li class="divider"></li>
                                <li><a href="#" onclick="deleteUser('<?= $user['uname'];?>');">删除用户</a></li>
                                <?= $commonAct($user["uname"]); ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>

    <h4>即将到期/免费试用</h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>用户(UA)</th><th>工单</th><th>Email(QQ)</th><th>最后登录</th><th>到期</th><th>类型</th><th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $timeS = $db->quote(time() + 15 * 24 * 3600);
        $timeE = $db->quote(time() - 15 * 24 * 3600);
        ?>
        <? foreach($db->query("SELECT * FROM `user` WHERE (`type`='free') OR (`type`!='no' AND `expired` < {$timeS} AND `expired` > {$timeE})") as $user): ?>
            <tr>
                <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => "ticket.status.open"]) ?></a></td>
                <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                <td><span title="<?= gmdate("Y.m.d H:i:s", $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                <td><span title="<?= gmdate("Y.m.d H:i:s", $user['expired']);?>"><?= rpTools::niceTime($user['expired']);?></span></td>
                <td><?= $rpL["global.userType"][$user['type']]; ?>(<?= rpVirtualHostModel::count(["uname" => $user['uname']]);?>)</td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                            操作
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="addTime('<?= $user['uname'];?>');">延时</a></li>
                            <li><a href="#" onclick="alertUser('<?= $user['uname'];?>');">续费提醒</a></li>
                            <li><a href="#" onclick="switchUser('<?= $user['uname'];?>');">变更付费方式</a></li>
                            <?= $commonAct($user["uname"]); ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>

    <h4>等待删除</h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>用户(UA)</th><th>工单</th><th>Email(QQ)</th><th>最后登录</th><th>到期</th><th>类型</th><th></th>
        </tr>
        </thead>
        <tbody>
        <? $time = $db->quote(time());?>
        <? foreach($db->query("SELECT * FROM `user` WHERE `expired` < {$timeE} AND `type`!='no'") as $user): ?>
            <tr>
                <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => "ticket.status.open"]) ?></a></td>
                <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                <td><span title="<?= gmdate("Y.m.d H:i:s", $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                <td><span title="<?= gmdate("Y.m.d H:i:s", $user['expired']);?>"><?= rpTools::niceTime($user['expired']);?></span></td>
                <td><?= $rpL["global.userType"][$user['type']]; ?>(<?= rpVirtualHostModel::count(["uname" => $user['uname']]);?>)</td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                            操作
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="addTime('<?= $user['uname'];?>');">延时</a></li>
                            <li><a href="#" onclick="alertUser('<?= $user['uname'];?>');">续费提醒</a></li>
                            <li><a href="#" onclick="disableUser('<?= $user['uname'];?>');">取消用户</a></li>
                            <?= $commonAct($user["uname"]); ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>

    <h4>正常用户</h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>用户(UA)</th><th>工单</th><th>Email(QQ)</th><th>最后登录</th><th>到期</th><th>类型</th><th></th>
        </tr>
        </thead>
        <tbody>
        <? $time = $db->quote(time());?>
        <? foreach($db->query("SELECT * FROM `user` WHERE `expired` > {$timeS} AND `type`!='no' AND `type`!='free'") as $user): ?>
            <tr>
                <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => rpTicketModel::OPEN]) ?></a></td>
                <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                <td><span title="<?= gmdate("Y.m.d H:i:s", $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                <td><span title="<?= gmdate("Y.m.d H:i:s", $user['expired']);?>"><?= rpTools::niceTime($user['expired']);?></span></td>
                <td><?= $rpL["global.userType"][$user['type']]; ?>(<?= rpVirtualHostModel::count(["uname" => $user['uname']]);?>)</td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                            操作
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="addTime('<?= $user['uname'];?>');">延时</a></li>
                            <li><a href="#" onclick="switchUser('<?= $user['uname'];?>');">变更付费方式</a></li>
                            <?= $commonAct($user["uname"]); ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</section>

<? $base->output(); ?>
