<?php
/*
精英王子, m@jybox.net
http://jyprince.me/
2013.4.10
GPLv3

只支持Linux环境, 需开启短标记, 需启用`shell——exec`.
*/

global $shellResult;

$shellResult["free"] = shell_exec("free -m");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>进程信息</title>
    <link href="http://lib.sinaapp.com/js/bootstrap/latest/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="http://lib.sinaapp.com/js/bootstrap/latest/css/bootstrap-responsive.min.css" rel="stylesheet"
          type="text/css"/>
    <style type="text/css">
            /* 左侧导航栏 */
        .sidenav {
            width: 228px;
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

        .sidenav.affix {
            top: 40px;
        }

        .sidenav > li:first-child > a {
            -webkit-border-radius: 6px 6px 0 0;
            -moz-border-radius: 6px 6px 0 0;
            border-radius: 6px 6px 0 0;
        }

            /* 全局常规 */
        body {
            font-family: "WenQuanYi Micro Hei", "WenQuanYi Zen Hei", "Microsoft YaHei", arial, sans-serif;
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

        pre {
            font-family: 'Courier New', Courier, monospace;
            color: #008200;
        }

            /* */
        .accordion-group {
            border: none;
        }

        .bar.pull-left {
            padding-top: 3px;
            line-height: 16px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".sidenav-bar" screen_capture_injected="true" class="well">
<div class="container">
    <div class="row-fluid">
        <div class="span3 sidenav-bar">
            <ul data-spy="affix" class="nav nav-list sidenav">
                <li class="active"><a href="#memoryt"><i class="icon-chevron-right"></i> 内存</a></li>
                <li><a href="#limits"><i class="icon-chevron-right"></i> 试用帐号限制</a></li>
                <li><a href="#rule"><i class="icon-chevron-right"></i> 审核原则</a></li>
            </ul>
        </div>
        <div class="span9">
            <section id="memory">
                <?php
                preg_match("/Mem:\\s+(?P<total>\\d+)\\s+(?P<used>\\d+)\\s+(?P<free>\\d+)\\s+(?P<shared>\\d+)\\s+(?P<buffers>\\d+)\\s+(?P<cached>\\d+)/", $shellResult["free"], $memInfo);
                preg_match("/Swap:\\s+(?P<swapTotal>\\d+)\\s+(?P<swapUsed>\\d+)\\s+(?P<swapFree>\\d+)/", $shellResult["free"], $r);
                $memInfo = array_merge($memInfo, $r);

                $realMemUsed = $memInfo["used"] - $memInfo["shared"] - $memInfo["buffers"] - $memInfo["cached"];
                $realMemPer = round($realMemUsed / $memInfo["total"] * 100);
                $cachedMemPer = round($memInfo["cached"] / $memInfo["total"] * 100);
                $buffersMemPer = round($memInfo["buffers"] / $memInfo["total"] * 100);
                $swapUsedMemPer = round($memInfo["swapUsed"] / $memInfo["swapTotal"] * 100);
                ?>
                <header>内存</header>
                <div class="progress progress-striped active" style="font-size: 16px;">
                    <div class="bar pull-left" style="width:<?= $realMemPer; ?>%;background-color:#dd514c;">
                        <?= $realMemPer; ?>%
                    </div>
                    <div class="bar pull-left" style="width:<?= $cachedMemPer; ?>%;background-color:#5BC0DE;">
                        <?= $cachedMemPer; ?>%
                    </div>
                    <div class="bar pull-left" style="width:<?= $buffersMemPer; ?>%;background-color:#62C462;">
                        <?= $buffersMemPer; ?>%
                    </div>
                    <?= (100 - $realMemPer - $cachedMemPer - $buffersMemPer);?>%
                </div>
                <? if($swapUsedMemPer > 1): ?>
                    <div class="progress progress-striped active" style="font-size:16px;">
                        <div class="bar pull-left"
                             style="width:<?php echo $swapUsedMemPer; ?>%;background-color:#FBB450;">
                            <?= $swapUsedMemPer; ?>%
                        </div>
                        <?= (100 - $swapUsedMemPer);?>%
                    </div>
                <? endif;?>
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
                            查看原始命令(free)
                        </a>
                    </div>
                    <div id="preFree" class="accordion-body collapse">
                        <pre><?php echo htmlspecialchars($shellResult["free"]);?></pre>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="pull-right" style="margin-top: 40px;">
        <script type="text/javascript" src="//static2.jybox.net/my-website/analyzer.js"></script>
        精英王子
    </div>
</div>
<script type='text/javascript' src='http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='http://lib.sinaapp.com/js/bootstrap/latest/js/bootstrap.min.js'></script>
</body>
</html>
