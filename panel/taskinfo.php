<?php

define("lpOFF_Exception",true);

require_once("./LightPHP/lp-load.php");
require_once("./config.php");

?>
<!DOCTYPE html>
<html lang="cn">
  <head>
    <meta charset="utf-8">
    <title>进程信息-RP主机</title>
    <?= lpTools::linkTo("bootstrap",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-responsive",NULL,false); ?>
    <?= lpTools::linkTo("lp-css"); ?>
    <style>
      hr
{
  margin:10px 0;
}

pre
{
  font-family: 'Courier New', Courier, monospace; 
  color: #008200
}

li
{
  line-height:125%;
}

.nopadding td
{
  padding:0 0 0 0;
}
    </style>
  </head>
  <body>
    <div class="container" style="font-size:16px;line-height:24px;">
      <div style="height:40px;">
      </div>
      <div class="row">
        <div class="span12">
          <section class='box well'>
            <header><h3>内存和交换空间</h3></header>
            <?php
              $str = @file("/proc/meminfo");
              $str = implode("", $str);
              preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?Cached\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);
              preg_match_all("/Buffers\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buffers);
              $res['memTotal'] = round($buf[1][0]/1024, 2);
              $res['memFree'] = round($buf[2][0]/1024, 2);
              $res['memBuffers'] = round($buffers[1][0]/1024, 2);
              $res['memCached'] = round($buf[3][0]/1024, 2);
              $res['memUsed'] = $res['memTotal']-$res['memFree'];
              $res['memRealUsed'] = $res['memTotal'] - $res['memFree'] - $res['memCached'] - $res['memBuffers'];
              $res['swapTotal'] = round($buf[4][0]/1024, 2);
              $res['swapFree'] = round($buf[5][0]/1024, 2);
              $res['swapUsed'] = round($res['swapTotal']-$res['swapFree'], 2);
            ?>
            <hr />
            <div class="progress progress-striped active" style="font-size:14px;text-align:center;">
              <?php
                $usedMemPer=round($res['memRealUsed']/$res['memTotal']*100);
                $pageCacheMemPer=round($res['memCached']/$res['memTotal']*100);
                $buffersMemPer=round($res['memBuffers']/$res['memTotal']*100);
                $swapUsedMemPer=round($res['swapUsed']/$res['swapTotal']*100);
              ?>
              <div class="bar pull-left" style="width:<?php echo $usedMemPer; ?>%;font-size:14px;background-color:#dd514c;"><?php echo $usedMemPer; ?>%</div>
              <div class="bar pull-left" style="width:<?php echo $pageCacheMemPer; ?>%;font-size:14px;background-color:#5BC0DE;"><?php echo $pageCacheMemPer; ?>%</div>
              <div class="bar pull-left" style="width:<?php echo $buffersMemPer; ?>%;font-size:14px;background-color:#62C462;"><?php echo $buffersMemPer; ?>%</div>
              <?php echo 100-$usedMemPer-$pageCacheMemPer-$buffersMemPer; ?>%
            </div>
            <?php if($swapUsedMemPer>1) { ?>
              <div class="progress progress-striped active" style="font-size:14px;text-align:center;">
                <div class="bar pull-left" style="width:<?php echo $swapUsedMemPer; ?>%;font-size:14px;background-color:#FBB450;"><?php echo $swapUsedMemPer; ?>%</div>
                <?php echo 100-$swapUsedMemPer; ?>%
              </div>
            <?php } ?>
            <span class="label label-important">应用程序使用内存</span>
            <span class="label label-info">页面缓存</span>
            <span class="label label-success">磁盘缓冲</span>
            <?php if($swapUsedMemPer>1) { ?>
              <span class="label label-warning">交换空间</span>
            <?php } ?>
            <span class="label">空闲内存</span>
            <hr />
            <div class="accordion-group" style="margin-top:10;border:none;">
              <div class="accordion-heading" style="margin-bottom:5px;">
                <a class="btn btn-info" data-toggle="collapse" href="#preFree">
                  查看原始命令(free)
                </a>
              </div>
              <div id="preFree" class="accordion-body collapse" style="height:0px;">
                <pre><?php echo htmlspecialchars(shell_exec("free -m"));?></pre>
              </div>
            </div>
          </section>
          <section class='box well'>
            <header><h3>系统负荷</h3></header>
            <?php
              $str = @file("/proc/uptime");
              $str = explode(" ", implode("", $str));
              $str = trim($str[0]);
              $min = $str / 60;
              $hours = $min / 60;
              $days = floor($hours / 24);
              $hours = floor($hours - ($days * 24));
              $min = floor($min - ($days * 60 * 24) - ($hours * 60));
              if ($days !== 0) $res['uptime'] = $days." days ";
              if ($hours !== 0) $res['uptime'] .= $hours." hours ";
              $res['uptime'] .= $min." mins";
              
              $str = @file("/proc/loadavg");
              $str = explode(" ", implode("", $str));
              $str = array_chunk($str, 4);
              $res['loadAvg'] = implode(" ", $str[0]);
              
              $res['loadAvg']=str_replace(" ",'</span>  <span class="label label-info">',$res['loadAvg']);
              $res['loadAvg']='<span class="label label-info"> '.$res['loadAvg']." </span>";
              
              $uptimeInfo=shell_exec("uptime");
            ?>
            <hr />
            <table class="table table-striped table-bordered table-condensed">
              <tbody>
                <tr><td>服务器时间</td><td><?php echo date("Y-n-j H:i:s");?></td></tr>
                <tr><td>已运行时间</td><td><?php echo $res['uptime'];?></td></tr>
                <tr><td>系统负荷</td><td><?php echo $res['loadAvg'];?></td></tr>
              </tbody>
            </table>
            <hr />
            <div class="accordion-group" style="margin-top:10;border:none;">
              <div class="accordion-heading" style="margin-bottom:5px;">
                <a class="btn btn-info" data-toggle="collapse" href="#preUptime">
                  查看原始命令(uptime)
                </a>
              </div>
              <div id="preUptime" class="accordion-body collapse" style="height:0px;">
                <pre><?php echo htmlspecialchars($uptimeInfo);?></pre>
              </div>
            </div>
          </section>
          <section class='box well'>
            <?php
              $userInfo=array();
              $procOutput="";
              $psInfo=shell_exec("ps xufwa");
              $psArray=explode("\n",$psInfo);
              for($i=1;$i<count($psArray);$i++)
              {
                $vpsArrayInfo=$psArray[$i];
                while(stripos($psArray[$i],"  "))
                {
                  $psArray[$i]=str_replace("  "," ",$psArray[$i]);
                }
                $procArray=explode(" ",$psArray[$i]);
                
                @$userInfo[$procArray[0]]["cpuPer"]+=$procArray[2];
                @$userInfo[$procArray[0]]["memPer"]+=$procArray[3];
                @$userInfo[$procArray[0]]["swapMem"]+=$procArray[4];
                @$userInfo[$procArray[0]]["realMem"]+=$procArray[5];
                @$userInfo[$procArray[0]]["procNum"]++;
                
                @$escedprocArray7=htmlspecialchars($procArray[7]);
                $cmd=str_replace(" ","&nbsp;",htmlspecialchars(substr($vpsArrayInfo,64)));
                
                if(@$procArray[5]>0)
                {
                @$procOutput.= <<< EOF
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
EOF;
                }
              }
            ?>
            <header><h3>用户</h3></header>
            <hr />
            <?php
              preg_match_all('/(\\d)+ user/',$uptimeInfo,$reslut);
            ?>
            当前<?php echo $reslut[1][0];?>名用户在线，<?php echo count($userInfo);?>名用户存在进程.
            <hr />
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
                <?php foreach($userInfo as $k => $v) { ?>
                <tr>
                  <td><?php echo $k; ?></td>
                  <td><?php echo $v["procNum"]; ?></td>
                  <td><?php echo $v["cpuPer"]; ?>%</td>
                  <td><?php echo round($v["realMem"]/1024); ?> MB(<?php echo $v["memPer"]; ?>%)</td>
                  <td><?php echo round($v["swapMem"]/1024); ?> MB</td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </section>
          </div></div></div>
          <section class='box well'>
            <header><h3>进程</h3></header>
            <hr />
            <table class="nopadding table table-striped table-bordered table-condensed" style="font-size:12px;line-height:12px;">
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
                <?php echo $procOutput; ?>
              </tbody>
            </table>
            <hr />
            <div class="accordion-group" style="margin-top:10;border:none;">
              <div class="accordion-heading" style="margin-bottom:5px;">
                <a class="btn btn-info" data-toggle="collapse" href="#prePs">
                  查看原始命令(ps)
                </a>
              </div>
              <div id="prePs" class="accordion-body collapse" style="height:0px;">
                <pre><?php echo htmlspecialchars(shell_exec("ps xufwa"));?></pre>
              </div>
            </div>
          </section>
    </div>
    <?= lpTools::linkTo("jquery",NULL,false); ?>
    <?= lpTools::linkTo("bootstrap-js",NULL,false); ?>
    <script src="http://hm.baidu.com/h.js?77016691cd5a049005dba568b5164b59" type="text/javascript"></script>
  </body>
</html>
