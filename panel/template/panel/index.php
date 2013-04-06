<?php

global $rpROOT, $rpL, $rpCfg, $rpVHostType;

require_once("{$rpROOT}/include/vhost/vhost.php");

$base = new lpTemplate("{$rpROOT}/template/base.php");
$base->title = "控制面板主页";

$user = rpApp::q("user")->where(["uname" => rpAuth::uname()])->top();
$logs = rpApp::q("log")->where(["uname" => rpAuth::uname()])->limit(30)->select();
$hosts = rpApp::q("virtualhost")->where(["uname" => rpAuth::uname()])->select();

?>

<? lpTemplate::beginBlock(); ?>
<li class="active"><a href="#section-index"><i class="icon-chevron-right"></i> 概述</a></li>
<li><a href="#section-access"><i class="icon-chevron-right"></i> 远程访问</a></li>
<li><a href="#section-website"><i class="icon-chevron-right"></i> Web站点管理</a></li>
<li><a href="#section-log"><i class="icon-chevron-right"></i> 日志摘要</a></li>
<li><a href="/panel/logs/"><i class="icon-share"></i> 详细日志</a></li>
<? $base->sidenav = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<style type="text/css">
    .input-xxlarge {
        width: 250px;
    }

    #section-access button {
        margin-bottom: 10px;
    }
</style>
<? $base->header = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
<script type='text/javascript'>
    var rpL = new Array();
    rpL["panel.newSite"] = '<?= $rpL["panel.js.newSite"];?>';
    rpL["panel.viewNginxExtConfig"] = '<?= $rpL["panel.js.viewNginxExtConfig"];?>';
    rpL["panel.viewApache2ExtConfig"] = '<?= $rpL["panel.js.viewApache2ExtConfig"];?>';
</script>
<script type='text/javascript' src='/script/panel.js'></script>
<? $base->endOfBody = lpTemplate::endBlock(); ?>

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
    <p>
        账户类型：<?= $rpL["global.userType"][$user["type"]] ?><br/>
        到期时间：<span
            title="<?= gmdate("Y.m.d H:i:s", $user["expired"]); ?>"><?= rpTools::niceTime($user["expired"]);?></span>
        <a class="btn btn-success btn-inline" href="/pay/"> 续费</a>
    </p>
</section>

<section id="section-access">
    <header>远程访问</header>
    <div>
        <input type="text" class="input-xxlarge" id="sshpasswd" name="sshpasswd"/>
        <button class="btn btn-success" onclick="changePasswd('sshpasswd', false);">修改SSH/SFTP密码</button>
    </div>
    <div>
        <input type="text" class="input-xxlarge" id="mysqlpasswd" name="mysqlpasswd"/>
        <button class="btn btn-success" onclick="changePasswd('mysqlpasswd', false);">修改MySQL密码</button>
    </div>
    <div>
        <input type="text" class="input-xxlarge" id="panelpasswd" name="panelpasswd"/>
        <button class="btn btn-success" onclick="changePasswd('panelpasswd', true);">修改面板(即该网页)密码
        </button>
    </div>
    <div>
        <input type="text" class="input-xxlarge" id="pptppasswd" name="pptppasswd"/>
        <button class="btn btn-success" onclick="changePasswd('pptppasswd', false);">修改PPTP
            VPN密码
        </button>
    </div>
</section>

<section id="section-website">
    <header>Web站点管理</header>
    <div>
        <a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.extConfig"]; ?>">额外</a>的Nginx配置文件： 0字节(<a
            id="nginx-extConfig" href="#">查看</a>).<br/>
        额外的Apache2配置文件： 0字节(<a id="apache2-extConfig" href="#">查看</a>).
    </div>
    <hr/>
    <? while($hosts->read()): ?>
        <div class="box">
            <div>
                <a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.ison"]; ?>">是否开启</a>：<span
                    class="label"><?= $hosts["ison"] ? "是" : "否";?></span> |
                <a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.id"]; ?>">站点ID</a>：<span
                    class="label"><?= $hosts["id"];?></span> |
                <a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.domain"]; ?>">域名</a>：<span
                    class="label"><?= $hosts["domains"];?></span>
            </div>
            <div>
                <a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.type"]; ?>">站点类型</a>：<span
                    class="label"><?= $rpVHostType[$hosts["type"]]["name"];?></span> |
                <a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.source"]; ?>">数据源</a>： <span
                    class="label"><?= $hosts["source"];?></span>
            </div>
            <button class="btn btn-danger pull-right" onclick="deleteWebsite(<?= $hosts["id"]; ?>);return false;">删除
            </button>
            <button class="btn btn-info pull-right" style="margin-right:10px;"
                    onclick="editWebsite(<?= $hosts["id"]; ?>);return false;">修改
            </button>
        </div>
    <? endwhile; ?>
    <div class="box">
        <button id="new-website" class="btn btn-success pull-right">添加站点</button>
    </div>
</section>

<section id="section-log">
    <header>日志</header>
    <p>以下为最新30条的摘要 (<a href="/panel/logs/">详细日志</a>).</p>

    <div>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>id</th>
                <th>时间</th>
                <th>摘要</th>
            </tr>
            </thead>
            <tbody>
            <? while($logs->read()): ?>
                <tr>
                    <td><?= $logs["id"];?></td>
                    <td><span
                            title="<?= gmdate("Y.m.d H:i:s", $logs["time"]); ?>"><?= rpTools::niceTime($logs["time"]);?></span>
                    </td>
                    <? $args = json_decode($logs["info"]);
                    array_unshift($args, $rpL[$logs["type"]]);
                    ?>
                    <td><?= htmlentities(call_user_func_array("sprintf", $args));?></td>
                </tr>
            <? endwhile; ?>
            </tbody>
        </table>
        <div>
</section>

<? $base->output(); ?>
