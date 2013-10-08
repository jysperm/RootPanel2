<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["base", "form", "admin"]);

$base = new lpTemplate(rpROOT . "/template/base.php");
$base["title"] = l("admin.title");

$db = f("lpDBDrive");

$commonAct = function($uname)
{
    $cookieUser = rpAuth::USER;
    $cookiePasswd = rpAuth::PASSWD;
    $myUName = rpAuth::uname();
    $getLoginas = "?{$cookieUser}={$myUName}&{$cookiePasswd}={$_COOKIE[$cookiePasswd]}&rp_changeuname={$uname}";
    $getLog = "&{$getLoginas}&goUrl=/panel/logs/";

    lpTemplate::beginBlock(); ?>
    <li class="divider"></li>
    <li><a href="#" onclick="newTK('<?= $uname;?>');"><?= l("admin.op.createTK");?></a></li>
    <li><a href="/user/set-cookie/<?= $getLog;?> "><?= l("admin.op.log");?></a></li>
    <li><a href="/user/set-cookie/<?= $getLoginas;?> "><?= l("admin.op.loginas");?></a></li>
    <li><a href="#" onclick="getPasswd('<?= $uname;?>');"><?= l("admin.op.getPasswd");?></a></li>
    <? return lpTemplate::endBlock();
};

?>

<? lpTemplate::beginBlock();?>
<li class="active"><a  href="#section-index"><i class="icon-chevron-right"></i> <?= l("admin.index");?></a></li>
<li><a href="#section-users"><i class="icon-chevron-right"></i> <?= l("admin.users");?></a></li>
<li><a href="/admin/logs/"><i class="icon-chevron-right"></i> <?= l("admin.log");?></a></li>
<li><a href="/admin/ticket/"><i class="icon-share"></i> <?= l("admin.ticket");?></a></li>
<? $base['sidenav'] = lpTemplate::endBlock();?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    .input-xxlarge {
        width: 250px;
    }
</style>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type='text/javascript' src='<?= c("StaticPrefix");?>/locale/<?= f("lpLocale")->language();?>/locale.js'></script>
<script type='text/javascript' src='<?= c("StaticPrefix");?>/script/admin.js'></script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<div class="modal hide" id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialogLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="dialogLabel" class="dialog-title"></h3>
    </div>
    <div class="modal-body dialog-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?= l("form.cancel");?></button>
        <button class="btn btn-primary dialog-ok"><?= l("form.save");?></button>
    </div>
</div>

<section id="section-index">
    <header><?= l("admin.index");?></header>
</section>

<section id="section-users">
    <header><?= l("admin.users");?></header>
    <h4><?= l("admin.users.no");?></h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th><?= l("admin.users.user");?></th><th><?= l("admin.users.ticket");?></th>
            <th><?= l("admin.users.email");?></th><th><?= l("admin.users.last");?></th><th></th>
        </tr>
        </thead>
        <tbody>
            <? foreach(rpUserModel::select(["type" => "no"]) as $user): ?>
            <? if((new rpUserModel($user['id']))->isAdmin()) continue; ?>
                <tr>
                    <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                    <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => "ticket.status.open"]) ?></a></td>
                    <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                    <td><span title="<?= gmdate(l("base.fullTime"), $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                                <?= l("admin.operator");?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick="enableUser('<?= $user['uname'];?>', 'std');"><?= l("admin.op.toStd");?></a></li>
                                <li><a href="#" onclick="enableUser('<?= $user['uname'];?>', 'ext');"><?= l("admin.op.toExt");?></a></li>
                                <li><a href="#" onclick="enableUser('<?= $user['uname'];?>', 'free');"><?= l("admin.op.toFree");?></a></li>
                                <li class="divider"></li>
                                <li><a href="#" onclick="deleteUser('<?= $user['uname'];?>');"><?= l("admin.op.delete");?></a></li>
                                <?= $commonAct($user["uname"]); ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>

    <h4><?= l("admin.users.free");?></h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th><?= l("admin.users.user");?></th><th><?= l("admin.users.ticket");?></th>
            <th><?= l("admin.users.email");?></th><th><?= l("admin.users.last");?></th>
            <th><?= l("admin.users.expired");?></th><th><?= l("admin.users.type");?></th><th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $timeS = $db->quote(time() + 15 * 24 * 3600);
        $timeE = $db->quote(time() - 15 * 24 * 3600);
        ?>
        <? foreach($db->query("SELECT * FROM `user` WHERE (`type`='free' AND `expired` > {$timeE}) OR (`type`!='no' AND `expired` < {$timeS} )") as $user): ?>
            <tr>
                <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => "ticket.status.open"]) ?></a></td>
                <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                <td><span title="<?= gmdate(l("base.fullTime"), $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                <td><span title="<?= gmdate(l("base.fullTime"), $user['expired']);?>"><?= rpTools::niceTime($user['expired']);?></span></td>
                <td><?= l("base.userType")[$user['type']]; ?>(<?= rpVirtualHostModel::count(["uname" => $user['uname']]);?>)</td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                            <?= l("admin.operator");?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="addTime('<?= $user['uname'];?>');"><?= l("admin.op.addTime");?></a></li>
                            <li><a href="#" onclick="alertUser('<?= $user['uname'];?>');"><?= l("admin.op.alert");?></a></li>
                            <li><a href="#" onclick="switchUser('<?= $user['uname'];?>');"><?= l("admin.op.switch");?></a></li>
                            <li><a href="#" onclick="editSettings('<?= $user['uname'];?>');"><?= l("admin.op.editSettings");?></a></li>
                            <?= $commonAct($user["uname"]); ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>

    <h4><?= l("admin.users.waitDel");?></h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th><?= l("admin.users.user");?></th><th><?= l("admin.users.ticket");?></th>
            <th><?= l("admin.users.email");?></th><th><?= l("admin.users.last");?></th>
            <th><?= l("admin.users.expired");?></th><th><?= l("admin.users.type");?></th><th></th>
        </tr>
        </thead>
        <tbody>
        <? $time = $db->quote(time());?>
        <? foreach($db->query("SELECT * FROM `user` WHERE `expired` < {$timeE} AND `type`!='no'") as $user): ?>
            <tr>
                <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => "ticket.status.open"]) ?></a></td>
                <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                <td><span title="<?= gmdate(l("base.fullTime"), $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                <td><span title="<?= gmdate(l("base.fullTime"), $user['expired']);?>"><?= rpTools::niceTime($user['expired']);?></span></td>
                <td><?= l("base.userType")[$user['type']]; ?>(<?= rpVirtualHostModel::count(["uname" => $user['uname']]);?>)</td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                            <?= l("admin.operator");?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="addTime('<?= $user['uname'];?>');"><?= l("admin.op.addTime");?></a></li>
                            <li><a href="#" onclick="alertUser('<?= $user['uname'];?>');"><?= l("admin.op.alert");?></a></li>
                            <li><a href="#" onclick="disableUser('<?= $user['uname'];?>');"><?= l("admin.op.disable");?></a></li>
                            <li><a href="#" onclick="editSettings('<?= $user['uname'];?>');"><?= l("admin.op.editSettings");?></a></li>
                            <?= $commonAct($user["uname"]); ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>

    <h4><?= l("admin.users.common");?></h4>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th><?= l("admin.users.user");?></th><th><?= l("admin.users.ticket");?></th>
            <th><?= l("admin.users.email");?></th><th><?= l("admin.users.last");?></th>
            <th><?= l("admin.users.expired");?></th><th><?= l("admin.users.type");?></th><th></th>
        </tr>
        </thead>
        <tbody>
        <? $time = $db->quote(time());?>
        <? foreach($db->query("SELECT * FROM `user` WHERE `expired` > {$timeS} AND `type`!='no' AND `type`!='free'") as $user): ?>
            <tr>
                <td><span title="<?= str_replace("\"", "", $user['lastloginua']) . " " . $user['lastloginip'];?>"><?= $user['uname'];?> (<?= $user['id'];?>)</span></td>
                <td><a href="/admin/ticket/<?= $user['uname'];?>/"><?= rpTicketModel::count(["uname" => $user['uname'], "status" => rpTicketModel::OPEN]) ?></a></td>
                <td><?= $user['email'];?>(<?= $user['qq'];?>)</td>
                <td><span title="<?= gmdate(l("base.fullTime"), $user['lastlogintime']);?>"><?= rpTools::niceTime($user['lastlogintime']);?></span></td>
                <td><span title="<?= gmdate(l("base.fullTime"), $user['expired']);?>"><?= rpTools::niceTime($user['expired']);?></span></td>
                <td><?= l("base.userType")[$user['type']]; ?>(<?= rpVirtualHostModel::count(["uname" => $user['uname']]);?>)</td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                            <?= l("admin.operator");?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="addTime('<?= $user['uname'];?>');"><?= l("admin.op.addTime");?></a></li>
                            <li><a href="#" onclick="switchUser('<?= $user['uname'];?>');"><?= l("admin.op.switch");?></a></li>
                            <li><a href="#" onclick="editSettings('<?= $user['uname'];?>');"><?= l("admin.op.editSettings");?></a></li>
                            <?= $commonAct($user["uname"]); ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>
