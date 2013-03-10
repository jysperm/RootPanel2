<?php
/* ---------------------------------------------------- */
/* 程序名称: Yahei-PHP探针[手机版]
/* 程序功能: 探测系统的Web服务器运行环境
/* 程序开发: Yahei.Net
/* 联系方式: info@Yahei.net
/* Date: 2011-11-8 / 2011-11-10
/* ---------------------------------------------------- */
/* 使用条款:
/* 1.你可以自由免费的使用本程序.
/* 2.你可以修改本程序,仅限自己使用.
/* 3.如果你修改本程序再发布,必须要有新的功能或内容.
/* 4.作者不对该程序运行显示的数据负任何责任.
/* ---------------------------------------------------- */
error_reporting(0); //抑制所有错误信息
@header("content-Type: text/html; charset=utf-8"); //语言强制
ob_start();

$version = "v0.1.1"; //版本号
$title = "雅黑PHP探针[手机版]";

define('HTTP_HOST', preg_replace('~^www\.~i', '', $_SERVER['HTTP_HOST']));

// 根据不同系统取得CPU相关信息
switch(PHP_OS)
{
	case "Linux":
		$sysReShow = (false !== ($sysInfo = sys_linux()))?"show":"none";
	break;
	
	case "FreeBSD":
		$sysReShow = (false !== ($sysInfo = sys_freebsd()))?"show":"none";
	break;
	
	case "WINNT":
		$sysReShow = (false !== ($sysInfo = sys_windows()))?"show":"none";
	break;
	
	default:
	break;
}

//linux系统探测
function sys_linux()
{
    // CPU
    if (false === ($str = @file("/proc/cpuinfo"))) return false;
    $str = implode("", $str);
    @preg_match_all("/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(\@.-]+)([\r\n]+)/s", $str, $model);
    @preg_match_all("/cpu\s+MHz\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $mhz);
    @preg_match_all("/cache\s+size\s{0,}\:+\s{0,}([\d\.]+\s{0,}[A-Z]+[\r\n]+)/", $str, $cache);
    @preg_match_all("/bogomips\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $bogomips);
    if (false !== is_array($model[1]))
	{
        $res['cpu']['num'] = sizeof($model[1]);
		/*
        for($i = 0; $i < $res['cpu']['num']; $i++)
        {
            $res['cpu']['model'][] = $model[1][$i].'&nbsp;('.$mhz[1][$i].')';
            $res['cpu']['mhz'][] = $mhz[1][$i];
            $res['cpu']['cache'][] = $cache[1][$i];
            $res['cpu']['bogomips'][] = $bogomips[1][$i];
        }*/
		if($res['cpu']['num']==1)
			$x1 = '';
		else
			$x1 = ' ×'.$res['cpu']['num'];
		$mhz[1][0] = ' | 频率:'.$mhz[1][0];
		$cache[1][0] = ' | 二级缓存:'.$cache[1][0];
		$bogomips[1][0] = ' | Bogomips:'.$bogomips[1][0];
		$res['cpu']['model'][] = $model[1][0].$mhz[1][0].$cache[1][0].$bogomips[1][0].$x1;
        if (false !== is_array($res['cpu']['model'])) $res['cpu']['model'] = implode("<br />", $res['cpu']['model']);
        if (false !== is_array($res['cpu']['mhz'])) $res['cpu']['mhz'] = implode("<br />", $res['cpu']['mhz']);
        if (false !== is_array($res['cpu']['cache'])) $res['cpu']['cache'] = implode("<br />", $res['cpu']['cache']);
        if (false !== is_array($res['cpu']['bogomips'])) $res['cpu']['bogomips'] = implode("<br />", $res['cpu']['bogomips']);
	}

    // NETWORK

    // UPTIME
    if (false === ($str = @file("/proc/uptime"))) return false;
    $str = explode(" ", implode("", $str));
    $str = trim($str[0]);
    $min = $str / 60;
    $hours = $min / 60;
    $days = floor($hours / 24);
    $hours = floor($hours - ($days * 24));
    $min = floor($min - ($days * 60 * 24) - ($hours * 60));
    if ($days !== 0) $res['uptime'] = $days."天";
    if ($hours !== 0) $res['uptime'] .= $hours."小时";
    $res['uptime'] .= $min."分钟";

    // MEMORY
    if (false === ($str = @file("/proc/meminfo"))) return false;
    $str = implode("", $str);
    preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?Cached\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);
	preg_match_all("/Buffers\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buffers);

    $res['memTotal'] = round($buf[1][0]/1024, 2);
    $res['memFree'] = round($buf[2][0]/1024, 2);
    $res['memBuffers'] = round($buffers[1][0]/1024, 2);
	$res['memCached'] = round($buf[3][0]/1024, 2);
    $res['memUsed'] = $res['memTotal']-$res['memFree'];
    $res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;

    $res['memRealUsed'] = $res['memTotal'] - $res['memFree'] - $res['memCached'] - $res['memBuffers']; //真实内存使用
	$res['memRealFree'] = $res['memTotal'] - $res['memRealUsed']; //真实空闲
    $res['memRealPercent'] = (floatval($res['memTotal'])!=0)?round($res['memRealUsed']/$res['memTotal']*100,2):0; //真实内存使用率

	$res['memCachedPercent'] = (floatval($res['memCached'])!=0)?round($res['memCached']/$res['memTotal']*100,2):0; //Cached内存使用率

    $res['swapTotal'] = round($buf[4][0]/1024, 2);
    $res['swapFree'] = round($buf[5][0]/1024, 2);
    $res['swapUsed'] = round($res['swapTotal']-$res['swapFree'], 2);
    $res['swapPercent'] = (floatval($res['swapTotal'])!=0)?round($res['swapUsed']/$res['swapTotal']*100,2):0;

    // LOAD AVG
    if (false === ($str = @file("/proc/loadavg"))) return false;
    $str = explode(" ", implode("", $str));
    $str = array_chunk($str, 4);
    $res['loadAvg'] = implode(" ", $str[0]);

    return $res;
}

//FreeBSD系统探测
function sys_freebsd()
{
	//CPU
	if (false === ($res['cpu']['num'] = get_key("hw.ncpu"))) return false;
	$res['cpu']['model'] = get_key("hw.model");
	//LOAD AVG
	if (false === ($res['loadAvg'] = get_key("vm.loadavg"))) return false;
	//UPTIME
	if (false === ($buf = get_key("kern.boottime"))) return false;
	$buf = explode(' ', $buf);
	$sys_ticks = time() - intval($buf[3]);
	$min = $sys_ticks / 60;
	$hours = $min / 60;
	$days = floor($hours / 24);
	$hours = floor($hours - ($days * 24));
	$min = floor($min - ($days * 60 * 24) - ($hours * 60));
	if ($days !== 0) $res['uptime'] = $days."天";
	if ($hours !== 0) $res['uptime'] .= $hours."小时";
	$res['uptime'] .= $min."分钟";
	//MEMORY
	if (false === ($buf = get_key("hw.physmem"))) return false;
	$res['memTotal'] = round($buf/1024/1024, 2);

	$str = get_key("vm.vmtotal");
	preg_match_all("/\nVirtual Memory[\:\s]*\(Total[\:\s]*([\d]+)K[\,\s]*Active[\:\s]*([\d]+)K\)\n/i", $str, $buff, PREG_SET_ORDER);
	preg_match_all("/\nReal Memory[\:\s]*\(Total[\:\s]*([\d]+)K[\,\s]*Active[\:\s]*([\d]+)K\)\n/i", $str, $buf, PREG_SET_ORDER);

	$res['memRealUsed'] = round($buf[0][2]/1024, 2);
	$res['memCached'] = round($buff[0][2]/1024, 2);
	$res['memUsed'] = round($buf[0][1]/1024, 2) + $res['memCached'];
	$res['memFree'] = $res['memTotal'] - $res['memUsed'];
	$res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;

	$res['memRealPercent'] = (floatval($res['memTotal'])!=0)?round($res['memRealUsed']/$res['memTotal']*100,2):0;

	return $res;
}

//取得参数值 FreeBSD
function get_key($keyName)
{
	return do_command('sysctl', "-n $keyName");
}

//确定执行文件位置 FreeBSD
function find_command($commandName)
{
	$path = array('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin');
	foreach($path as $p) 
	{
		if (@is_executable("$p/$commandName")) return "$p/$commandName";
	}
	return false;
}

//执行系统命令 FreeBSD
function do_command($commandName, $args)
{
	$buffer = "";
	if (false === ($command = find_command($commandName))) return false;
	if ($fp = @popen("$command $args", 'r')) 
	{
		while (!@feof($fp))
		{
			$buffer .= @fgets($fp, 4096);
		}
		return trim($buffer);
	}
	return false;
}

//windows系统探测
function sys_windows()
{
	if (PHP_VERSION >= 5)
	{
		$objLocator = new COM("WbemScripting.SWbemLocator");
		$wmi = $objLocator->ConnectServer();
		$prop = $wmi->get("Win32_PnPEntity");
	}
	else
	{
		return false;
	}

	//CPU
	$cpuinfo = GetWMI($wmi,"Win32_Processor", array("Name","L2CacheSize","NumberOfCores"));
	$res['cpu']['num'] = $cpuinfo[0]['NumberOfCores'];
	if (null == $res['cpu']['num']) 
	{
		$res['cpu']['num'] = 1;
	}/*
	for ($i=0;$i<$res['cpu']['num'];$i++)
	{
		$res['cpu']['model'] .= $cpuinfo[0]['Name']."<br />";
		$res['cpu']['cache'] .= $cpuinfo[0]['L2CacheSize']."<br />";
	}*/
	$cpuinfo[0]['L2CacheSize'] = ' ('.$cpuinfo[0]['L2CacheSize'].')';
	if($res['cpu']['num']==1)
		$x1 = '';
	else
		$x1 = '×'.$res['cpu']['num'];
	$res['cpu']['model'] = $cpuinfo[0]['Name'].$cpuinfo[0]['L2CacheSize'].$x1;
	// SYSINFO
	$sysinfo = GetWMI($wmi,"Win32_OperatingSystem", array('LastBootUpTime','TotalVisibleMemorySize','FreePhysicalMemory','Caption','CSDVersion','SerialNumber','InstallDate'));
	$sysinfo[0]['Caption']=iconv('GBK', 'UTF-8',$sysinfo[0]['Caption']);
	$sysinfo[0]['CSDVersion']=iconv('GBK', 'UTF-8',$sysinfo[0]['CSDVersion']);
	$res['win_n'] = $sysinfo[0]['Caption']." ".$sysinfo[0]['CSDVersion']." 序列号:{$sysinfo[0]['SerialNumber']} 于".date('Y年m月d日H:i:s',strtotime(substr($sysinfo[0]['InstallDate'],0,14)))."安装";
	//UPTIME
	$res['uptime'] = $sysinfo[0]['LastBootUpTime'];

	$sys_ticks = 3600*8 + time() - strtotime(substr($res['uptime'],0,14));
	$min = $sys_ticks / 60;
	$hours = $min / 60;
	$days = floor($hours / 24);
	$hours = floor($hours - ($days * 24));
	$min = floor($min - ($days * 60 * 24) - ($hours * 60));
	if ($days !== 0) $res['uptime'] = $days."天";
	if ($hours !== 0) $res['uptime'] .= $hours."小时";
	$res['uptime'] .= $min."分钟";

	//MEMORY
	$res['memTotal'] = round($sysinfo[0]['TotalVisibleMemorySize']/1024,2);
	$res['memFree'] = round($sysinfo[0]['FreePhysicalMemory']/1024,2);
	$res['memUsed'] = $res['memTotal']-$res['memFree'];	//上面两行已经除以1024,这行不用再除了
	$res['memPercent'] = round($res['memUsed'] / $res['memTotal']*100,2);

	$swapinfo = GetWMI($wmi,"Win32_PageFileUsage", array('AllocatedBaseSize','CurrentUsage'));

	// LoadPercentage
	$loadinfo = GetWMI($wmi,"Win32_Processor", array("LoadPercentage"));
	$res['loadAvg'] = $loadinfo[0]['LoadPercentage'];

	return $res;
}

function GetWMI($wmi,$strClass, $strValue = array())
{
	$arrData = array();

	$objWEBM = $wmi->Get($strClass);
	$arrProp = $objWEBM->Properties_;
	$arrWEBMCol = $objWEBM->Instances_();
	foreach($arrWEBMCol as $objItem) 
	{
		@reset($arrProp);
		$arrInstance = array();
		foreach($arrProp as $propItem) 
		{
			eval("\$value = \$objItem->" . $propItem->Name . ";");
			if (empty($strValue)) 
			{
				$arrInstance[$propItem->Name] = trim($value);
			} 
			else
			{
				if (in_array($propItem->Name, $strValue)) 
				{
					$arrInstance[$propItem->Name] = trim($value);
				}
			}
		}
		$arrData[] = $arrInstance;
	}
	return $arrData;
}


$uptime = $sysInfo['uptime'];
$stime = date("Y-n-j H:i:s");
$df = round(@disk_free_space(".")/(1024*1024*1024),3);
$dt = round(@disk_total_space(".")/(1024*1024*1024),3);

//判断内存如果小于1G，就显示M，否则显示G单位
if($sysInfo['memTotal']<1024)
{
	$memTotal = $sysInfo['memTotal']." M";
	$mt = $sysInfo['memTotal']." M";
	$mu = $sysInfo['memUsed']." M";
	$mf = $sysInfo['memFree']." M";
	$mc = $sysInfo['memCached']." M";	//cache化内存
	$mb = $sysInfo['memBuffers']." M";	//缓冲
	$st = $sysInfo['swapTotal']." M";
	$su = $sysInfo['swapUsed']." M";
	$sf = $sysInfo['swapFree']." M";
	$swapPercent = $sysInfo['swapPercent'];
	$memRealUsed = $sysInfo['memRealUsed']." M"; //真实内存使用
	$memRealFree = $sysInfo['memRealFree']." M"; //真实内存空闲
	$memRealPercent = $sysInfo['memRealPercent']; //真实内存使用比率
	$memPercent = $sysInfo['memPercent']; //内存总使用率
	$memCachedPercent = $sysInfo['memCachedPercent']; //cache内存使用率
}
else
{
	$memTotal = round($sysInfo['memTotal']/1024,3)." G";
	$mt = round($sysInfo['memTotal']/1024,3)." G";
	$mu = round($sysInfo['memUsed']/1024,3)." G";
	$mf = round($sysInfo['memFree']/1024,3)." G";
	$mc = round($sysInfo['memCached']/1024,3)." G";
	$mb = round($sysInfo['memBuffers']/1024,3)." G";
	$st = round($sysInfo['swapTotal']/1024,3)." G";
	$su = round($sysInfo['swapUsed']/1024,3)." G";
	$sf = round($sysInfo['swapFree']/1024,3)." G";
	$swapPercent = $sysInfo['swapPercent'];
	$memRealUsed = round($sysInfo['memRealUsed']/1024,3)." G"; //真实内存使用
	$memRealFree = round($sysInfo['memRealFree']/1024,3)." G"; //真实内存空闲
	$memRealPercent = $sysInfo['memRealPercent']; //真实内存使用比率
	$memPercent = $sysInfo['memPercent']; //内存总使用率
	$memCachedPercent = $sysInfo['memCachedPercent']; //cache内存使用率
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title.$version; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Powered by: Yahei.Net -->
<style type="text/css">
<!--
* {font-family: Tahoma, "Microsoft Yahei", Arial; }
body{text-align: center; margin: 0 auto; padding: 0; background-color:#FFFFFF;font-size:11px;font-family:Tahoma, Arial}
h1 {font-size: 16px; padding: 0; margin: 0; color: #333333; font-family: "Lucida Sans Unicode","Lucida Grande",sans-serif;}
a{color: #000000; text-decoration:none;}
a.black{color: #000000; text-decoration:none;}
table{clear:both;padding: 0; margin: 0 0 10px;border-collapse:collapse; border-spacing: 0;}
th{padding: 3px 6px; font-weight:bold;background:#3066a6;color:#FFFFFF;border:1px solid #3066a6; text-align:left;}
tr{padding: 0; background:#F7F7F7;}
td{padding: 3px 6px; border:1px solid #CCCCCC;}
#page {width: 240px; padding: 0px; margin: 0 auto; text-align: left;}
#header{position: relative; padding:5px;}
#footer {padding: 5px 0; text-align: center; font-size: 11px; font-family: Tahoma, Verdana;}
.word{word-break:break-all;}
-->
</style>
</head>
<body>

<div id="page">
    <div id="header">
        <h1><?php echo $title; ?></h1>
        <div id="download"></div>
    </div>

<!--服务器相关参数-->
<table width="100%" cellpadding="3" cellspacing="0">
  <tr>
    <td>IP地址: <?php echo $_SERVER['SERVER_ADDR'];?></td>
  </tr>
  <tr>
    <td>操作系统: <?php $os = explode(" ", php_uname()); echo $os[0];?></td>
  </tr>
  <tr>
    <td>Web引擎: <?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
  </tr>
  <tr>
    <td>Web端口: <?php echo $_SERVER['SERVER_PORT'];?></td>
  </tr>
  <tr>
    <td>当前时间: <?php echo $stime;?></td>
  </tr>
  <tr>
    <td>已运行时间: <?php echo $uptime;?></td>
  </tr>
  <tr>
    <td>系统负载: <?php echo $sysInfo['loadAvg'];?></td>
  </tr>
  <tr>
    <td>总空间: <?php echo $dt;?>&nbsp;G</td>
  </tr>
  <tr>
    <td>可用空间: <?php echo $df;?>&nbsp;G</td>
  </tr>
  <tr>
    <td class="word">CPU型号[<?php echo $sysInfo['cpu']['num'];?>核]: <?php echo $sysInfo['cpu']['model'];?></td>
  </tr>
  <tr>
    <td>物理内存: <?php echo $memTotal;?></td>
  </tr>
  <tr>
    <td>已用内存: <?php echo $mu;?></td>
  </tr>
  <tr>
    <td>空闲内存: <?php echo $mf;?></td>
  </tr>
<?php
if($sysInfo['memCached']>0)
{
?>
  <tr>
    <td>cache内存: <?php echo $mc;?></td>
  </tr>
<?php
}
//判断如果SWAP区为0，不显示
if($sysInfo['swapTotal']>0)
{
?>	
  <tr>
    <td>SWAP分区: <?php echo $st;?></td>
  </tr>
  <tr>
    <td>SWAP已用: <?php echo $su;?></td>
  </tr>
  <tr>
    <td>SWAP空闲: <?php echo $sf;?></td>
  </tr>
<?php
}
if (false !== ($strs = @file("/proc/net/dev"))) : 
for ($i = 2; $i < count($strs); $i++ ) :
preg_match_all( "/([^\s]+):[\s]{0,}(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $strs[$i], $info );
if($info[2][0]>0)
{
?>
  <tr>
    <td>网络-<?php echo $info[1][0]?>
		<br />已接收: <?php $tmp = round($info[2][0]/1024/1024, 3); $tmp2 = round($tmp/1024, 3);echo $tmp2;?> G
		<br />已发送: <?php $tmp = round($info[10][0]/1024/1024, 3); $tmp2 = round($tmp/1024, 3);echo $tmp2;?> G
	</td>
  </tr>
<?php
}
endfor;
endif; 
?>
</table>


<div id="footer">
&copy; <?php echo date("Y",time());?> <A HREF="http://www.Yahei.Net" target="_blank"><?php echo $title.$version;?></A>
</div>

</div>
</body>
</html>