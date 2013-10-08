<?php
/*
精英王子, m@jybox.net
http://jyprince.me/
2013.4.11

只支持Linux环境, 需开启短标记, 需启用`shell_exec()`.
仅支持各浏览器的最新版本, IE最低支持IE9.
后面落款处有作者的统计代码, 可删去.
*/

global $shellResult;

$shellResult["free"] = shell_exec("free -m");
$shellResult["uptime"] = shell_exec("uptime");
$shellResult["ps"] = shell_exec("ps xufwa");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>状态监视器</title>
    <link href="http://lib.sinaapp.com/js/bootstrap/latest/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="http://lib.sinaapp.com/js/bootstrap/latest/css/bootstrap-responsive.min.css" rel="stylesheet"
          type="text/css"/>
    <style type="text/css">
            /* 左侧导航栏 */
        .sidenav {
            width: 175px;
            margin: 30px 0 0;
            padding: 0;
            background-color: white;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
            -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, .065);
            -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, .065);
            box-shadow: 0 1px 4px rgba(0, 0, 0, .065);
        }

        .sidenav > li > a {
            display: block;
            margin: 0 0 -1px;
            padding: 8px 14px;
            border: 1px solid #E5E5E5;
        }

        .sidenav i {
            float: right;
            margin-top: 2px;
            margin-right: -6px;
            opacity: .25;
        }

        .sidenav > li:first-child > a {
            -webkit-border-radius: 6px 6px 0 0;
            -moz-border-radius: 6px 6px 0 0;
            border-radius: 6px 6px 0 0;
        }

            /* 全局常规 */
        body {
            font-family: "Microsoft YaHei", "WenQuanYi Micro Hei", "WenQuanYi Zen Hei", arial, sans-serif;
            font-size: 16px;
        }

        section {
            padding-top: 30px;
            line-height: 30px;
        }

        section header {
            font-size: 36px;
            line-height: 40px;
            font-weight: bold;
            padding-bottom: 9px;
            margin: 20px 0 30px;
            border-bottom: 1px solid #EEE;
        }

        pre, .code {
            font-family: 'Courier New', Courier, monospace;
            color: #008200;
        }

            /* 重载bootstrap */
        .accordion-group {
            border: none;
        }

        .progress, .bar.pull-left {
            font-size: 16px;
            line-height: 20px;
            text-align: center;
        }

        .procTable td {
            white-space: nowrap;
            font-size: 12px;
            padding: 1px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".sidenav-bar" screen_capture_injected="true" class="well">
<div class="container">
<div class="row-fluid">
<div class="span2 sidenav-bar">
    <ul data-spy="affix" class="nav nav-list sidenav">
        <li class="active"><a href="#memory"><i class="icon-chevron-right"></i> 内存</a></li>
        <li><a href="#system"><i class="icon-chevron-right"></i> 系统</a></li>
        <li><a href="#users"><i class="icon-chevron-right"></i> 用户</a></li>
        <li><a href="#process"><i class="icon-chevron-right"></i> 进程</a></li>
    </ul>
</div>
<div class="span10">
<section id="memory">
    <?php
    preg_match("/Mem:\\s+(?P<total>\\d+)\\s+(?P<used>\\d+)\\s+(?P<free>\\d+)\\s+(?P<shared>\\d+)\\s+(?P<buffers>\\d+)\\s+(?P<cached>\\d+)/", $shellResult["free"], $memInfo);
    preg_match("/Swap:\\s+(?P<swapTotal>\\d+)\\s+(?P<swapUsed>\\d+)\\s+(?P<swapFree>\\d+)/", $shellResult["free"], $r);
    $memInfo = array_merge($memInfo, $r);

    $realMemUsed = $memInfo["used"] - $memInfo["shared"] - $memInfo["buffers"] - $memInfo["cached"];
    $realMemPer = round($realMemUsed / $memInfo["total"] * 100);
    $cachedMemPer = round($memInfo["cached"] / $memInfo["total"] * 100);
    $buffersMemPer = round($memInfo["buffers"] / $memInfo["total"] * 100);
    $swapUsedMemPer = @round($memInfo["swapUsed"] / $memInfo["swapTotal"] * 100);
    ?>
    <header>内存</header>
    <div class="progress progress-striped active">
        <div class="bar pull-left" style="width:<?= $realMemPer; ?>%;background-color:#dd514c;">
            <?= $realMemPer; ?>%
        </div>
        <div class="bar pull-left" style="width:<?= $cachedMemPer; ?>%;background-color:#5BC0DE;">
            <?= $cachedMemPer; ?>%
        </div>
        <div class="bar pull-left" style="width:<?= $buffersMemPer; ?>%;background-color:#62C462;">
            <?= $buffersMemPer; ?>%
        </div>
        <?= (100 - $realMemPer - $cachedMemPer - $buffersMemPer); ?>%
    </div>
    <? if($swapUsedMemPer > 1): ?>
        <div class="progress progress-striped active">
            <div class="bar pull-left"
                 style="width:<?php echo $swapUsedMemPer; ?>%;background-color:#FBB450;">
                <?= $swapUsedMemPer; ?>%
            </div>
            <?= (100 - $swapUsedMemPer); ?>%
        </div>
    <? endif; ?>
    <span class="label label-important">应用程序使用内存</span>
    <span class="label label-info">页面缓存</span>
    <span class="label label-success">磁盘缓冲</span>
    <? if($swapUsedMemPer > 1): ?>
        <span class="label label-warning">交换空间</span>
    <? endif; ?>
    <span class="label">空闲内存</span>
    <hr/>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="btn btn-info" data-toggle="collapse" href="#preFree">
                查看原始命令
            </a>
        </div>
        <div id="preFree" class="accordion-body collapse">
            <pre><?php echo htmlspecialchars($shellResult["free"]); ?></pre>
        </div>
    </div>
</section>
<section id="system">
    <?php
    $uptimeInfo = explode(" ", file_get_contents("/proc/uptime"));
    $mins = trim($uptimeInfo[0]) / 60;
    $hours = $mins / 60;
    $days = floor($hours / 24);
    $hours = floor($hours - ($days * 24));
    $min = floor($mins - ($days * 60 * 24) - ($hours * 60));
    $uptimeStr = "";
    if($days)
        $uptimeStr = "{$days} days ";
    if($hours)
        $uptimeStr .= "{$hours} hours ";
    $uptimeStr .= "{$min} mins";

    $loadavgInfo = explode(" ", file_get_contents("/proc/loadavg"));
    $loadavgInfo = array_chunk($loadavgInfo, 4);
    $loadavgInfo = implode(" ", $loadavgInfo[0]);

    $loadavgInfo = str_replace(" ", '</span> <span class="label label-info">', $loadavgInfo);
    $loadavgStr = "<span class='label label-info'> {$loadavgInfo} </span>";
    ?>
    <header>系统</header>
    <table class="table table-striped table-bordered table-condensed">
        <tbody>
        <tr>
            <td>服务器时间</td>
            <td><?= date("Y-n-j H:i:s"); ?></td>
        </tr>
        <tr>
            <td>已运行时间</td>
            <td><?= $uptimeStr; ?></td>
        </tr>
        <tr>
            <td>系统负荷</td>
            <td><?= $loadavgStr; ?></td>
        </tr>
        </tbody>
    </table>
    <hr/>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="btn btn-info" data-toggle="collapse" href="#preUptime">
                查看原始命令
            </a>
        </div>
        <div id="preUptime" class="accordion-body collapse">
            <pre><?php echo htmlspecialchars($shellResult["uptime"]); ?></pre>
        </div>
    </div>
</section>
<section id="users">
    <header>用户</header>
    <?php
    $userInfo = array();
    $procOutput = "";
    $psInfo = $shellResult["ps"];
    $psArray = explode("\n", $psInfo);
    for($i = 1; $i < count($psArray); $i++) {
        $vpsArrayInfo = $psArray[$i];
        while(stripos($psArray[$i], "  "))
            $psArray[$i] = str_replace("  ", " ", $psArray[$i]);
        $procArray = explode(" ", $psArray[$i]);

        @$userInfo[$procArray[0]]["cpuPer"] += $procArray[2];
        @$userInfo[$procArray[0]]["memPer"] += $procArray[3];
        @$userInfo[$procArray[0]]["swapMem"] += $procArray[4];
        @$userInfo[$procArray[0]]["realMem"] += $procArray[5];
        @$userInfo[$procArray[0]]["procNum"]++;

        @$escedprocArray7 = htmlspecialchars($procArray[7]);
        $cmd = str_replace(" ", "&nbsp;", htmlspecialchars(substr($vpsArrayInfo, 64)));

        if(@$procArray[5] > 0) {
            @$procOutput .= <<< HTML
                <tr>
                  <td>{$procArray[0]}</td>
                  <td>{$procArray[1]}</td>
                  <td>{$procArray[2]}</td>
                  <td>{$procArray[3]}</td>
                  <td>{$procArray[4]}</td>
                  <td>{$procArray[5]}</td>
                  <td>{$procArray[6]}</td>
                  <td>{$escedprocArray7}</td>
                  <td>{$procArray[8]}</td>
                  <td>{$procArray[9]}</td>
                  <td>{$cmd}</td>
                </tr>
HTML;
        }
    }

    array_pop($userInfo);

    preg_match_all('/(\\d)+ user/', $shellResult["uptime"], $reslut);
    ?>
    当前<?= $reslut[1][0]; ?>名用户在线，<?= count($userInfo); ?>名用户存在进程.
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th>用户名</th>
            <th>进程数</th>
            <th>CPU占用</th>
            <th>物理内存占用</th>
            <th>虚拟内存占用</th>
        </tr>
        </thead>
        <tbody>
        <? foreach($userInfo as $k => $v): ?>
            <tr>
                <td><?= $k; ?></td>
                <td><?= $v["procNum"]; ?></td>
                <td><?= $v["cpuPer"]; ?>%</td>
                <td><?= round($v["realMem"] / 1024); ?> MB (<?= $v["memPer"]; ?>%)</td>
                <td><?= round($v["swapMem"] / 1024); ?> MB</td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</section>
<section id="process">
    <header>进程</header>
    <table class="nopadding table table-striped table-bordered table-condensed procTable code">
        <thead>
        <tr>
            <th>USER</th>
            <th>PID</th>
            <th>%CPU</th>
            <th>%MEM</th>
            <th>VSZ</th>
            <th>RES</th>
            <th>TTY</th>
            <th>STAT</th>
            <th>START</th>
            <th>TIME</th>
            <th>COMMAND</th>
        </tr>
        </thead>
        <tbody>
        <?= $procOutput; ?>
        </tbody>
    </table>
    <hr/>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="btn btn-info" data-toggle="collapse" href="#prePs">
                查看原始命令
            </a>
        </div>
        <div id="prePs" class="accordion-body collapse">
            <pre><?= htmlspecialchars($shellResult["ps"]); ?></pre>
        </div>
    </div>
</section>
</section>
</div>
</div>
<div class="pull-right">
    <script type="text/javascript" src="//static2.jybox.net/my-website/analyzer.js"></script>
    精英王子
</div>
</div>
<script type='text/javascript' src='http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='http://lib.sinaapp.com/js/bootstrap/latest/js/bootstrap.min.js'></script>
<!--[if lte IE 8]>
<script type='text/javascript' src='//static2.jybox.net/tools/kill-ie6.js'></script>
<![endif]-->
</body>
</html>
