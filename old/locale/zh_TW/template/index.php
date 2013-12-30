<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

/** @var lpConfig $rpCfg */
$rpCfg = f("lpConfig");
/** @var Locale $rpL */
$rpL = f("lpLocale");

$rpL->load(["admin-list", "contact"]);

$base = new lpTemplate(rpROOT . "/template/base.php");

$popover["free"] = <<< HTML
CPU時間限制(按天)：500秒(相當于0.6%)<br />
最小內存保證：10M<br />
內存競爭系數：0.4(與付費用戶競爭內存時的系數)<br />
硬盤限制：300M<br />
流量限制(按天)：300M<br />
流量限制(按月)：3G<br />
HTML;

$popover["evn"] = "RP主機提供了完整的Linux環境，即使RP主機默認不提供某語言的運行環境，妳也可以通過Linux下安裝軟件的常規方式自行安裝該語言環境.";

$popover["ext"] = "幫助妳解決網站架設、linux及其周邊軟件的問題，在您寂寞時還提供陪聊服務.";

$popover["proxy"] = <<< HTML
<ul>
<li>Secure Shell</li>
<li>Virtual Private Network</li>
<li>(Point to Point Tunneling Protocol)</li>
<li>ShadowSocks</li>
</ul>
HTML;

$popover["site"] = <<< HTML
可以運行幾乎所有常見的建站系統：<br />
<ul>
<li>WordPress 博客</li>
<li>PHPWind 論壇</li>
<li>Discuz! X 論壇</li>
<li>Typecho 博客</li>
<li>Drupal CMS</li>
<li>Anwsion 問答</li>
<li>MediaWiki 維基</li>
<li>DukoWiki 維基</li>
<li>寫不下了...</li>
</ul>
HTML;

?>

<? lpTemplate::beginBlock(); ?>
    <meta name="keywords"
          content="神馬終端,RP,RP主機,低價,月付,終端,主機,虛擬主機,vps,網站,建站,php,linode,日本,linux,美國,免備案,python,代理,pptp,c++,python,ssh"/>
    <meta name="description" content="RP主機是壹款爲技術宅(Geek)提供的Linux虛擬主機, 實際上就是壹台劃分了用戶的Linux服務器，每個用戶都可以幹自己想做的事情."/>
<? $base['header'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <li class="active"><a href="#what-is-rphost"><i class="icon-chevron-right"></i> RP主機是什麽</a></li>
    <li><a href="#what-can-it-do"><i class="icon-chevron-right"></i> RP主機能幹什麽</a></li>
    <li><a href="#try-and-buy"><i class="icon-chevron-right"></i> 試用和購買</a></li>
    <li><a href="#resource"><i class="icon-chevron-right"></i> 資源參數</a></li>
    <li><a href="#service"><i class="icon-chevron-right"></i> 客服</a></li>
    <li><a href="#agreement"><i class="icon-chevron-right"></i> 政策和約定</a></li>
<? $base['sidenav'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <section id="what-is-rphost">
        <header>RP主機是什麽</header>
        <p>
            RP主機是壹款爲技術宅(Geek)提供的Linux虛擬主機.<br/>
            和大多市面上的賣的虛擬主機相比，RP主機更加自由，妳幾乎可以在上面搭建所有類型的服務器，事實上，這相當于合租VPS了.<br/>
            而價格又不高，適合搭建個人博客等小規模應用，適合喜歡折騰新鮮技術的技術宅.
        </p>

        <p>
            RP主機實際上就是壹台劃分了用戶的Linux服務器，每個用戶都可以幹自己想做的事情.<br/>
            當然，會有以root權限運行的監控程序限制妳的資源使用，以免影響到其他用戶.<br/>
            爲了能夠使效率最大化，我們將最常用的壹些服務(例如Nginx、MySQL等)獨立出來，以root權限運行，大家共同使用，而不是每個人都單獨運行壹份.
        </p>
    </section>
    <section id="what-can-it-do">
        <header>RP主機能幹什麽</header>
        <p>
            妳得到的是壹個擁有極大權限的linux用戶，妳可以
        </p>
        <ul>
            <li><a href="#" rel="popover" data-content="<?= $popover['site']; ?>" data-original-title="建站系統">建立網站</a>，可以建立無限個網站，綁定無限個域名，無需備案
            </li>
            <li>使用PHP、Python、CGI等技術建立動態站點，RP主機支持<a href="#" rel="popover" data-content="<?= $popover['evn']; ?>"
                                                   data-original-title="環境支持">幾乎全部</a>編程語言
            </li>
            <li>訪問MySQL、Mongo、SQLite等各種數據庫</li>
            <li>配置反向代理、SSL版網站</li>
            <li>在終端運行PHP、Python、Go、NodeJS、C/C++程序，並且可以監聽端口來進行Socket通訊</li>
            <li>使用<a href="#" rel="popover" data-content="<?= $popover['proxy']; ?>"
                     data-original-title="接入世界性互聯網">多種技術</a>接入世界性互聯網
            </li>
        </ul>
    </section>
    <section id="try-and-buy">
        <header>試用和購買</header>
        <div class="row-fluid products-show">
            <div class="span4">
                <header>試用版</header>
                <div class="description">
                    所有人都可以申請壹個月的試用，需要填寫100字的申請，人工審核(可重複申請)。試用版有較爲嚴格的
                    <a href="#" rel="popover" data-content="<?= $popover['free']; ?>"
                       data-original-title="試用帳號限制">資源限制</a>
                </div>
                <p>
                    <a class="btn btn-success" href="/user/signup/">1. 注冊帳號</a>
                    <a class="btn btn-success" href="/ticket/list/?template=freeRequest">2. 填寫申請</a>
                </p>
            </div>
            <div class="span4">
                <header>標准版</header>
                <div class="description">每月8元，每季度19元.</div>
                <p>
                    <a class="btn btn-success" href="/user/signup/">1. 注冊帳號</a>
                    <a class="btn btn-success" href="/public/pay/">2. 淘寶付款</a>
                </p>
            </div>
            <div class="span4">
                <header>額外技術支持版</header>
                <div class="description">
                    每月15元，每季度35元.該版本的資源和標准版並無區別，但提供隨叫隨到的
                    <a href="#" rel="popover" data-content="<?= $popover['ext']; ?>" data-original-title="技術支持">技術支持</a>.
                </div>
                <p>
                    <a class="btn btn-success" href="/user/signup/">1. 注冊帳號</a>
                    <a class="btn btn-success" href="/public/pay/">2. 淘寶付款</a>
                </p>
            </div>
        </div>
        <hr/>
        <p>
            我們通過淘寶銷售，出現質量問題可以直接通過淘寶的流程進行維權。我們支持隨時退款，按照剩余天數(加收10%手續費)退款.
        </p>
    </section>
    <section id="resource">
        <header>資源參數</header>
        <? lpTemplate::outputFile(rpROOT . "/template/widget/node-list.php"); ?>
        <p>
            注意：妳運行的壹切服務，都在以上的限制之中，包括但不限于網頁、數據庫、梯子、Shell程序.
        </p>
    </section>
    <section id="service">
        <header>客服</header>
        <p>
            RP主機提供有工單系統，妳可以與客服溝通妳在使用中遇到的任何問題。<br/>
            `額外技術支持版`中提供隨叫隨到的技術支持，幫助妳解決網站架設、linux及其周邊軟件的問題，在您寂寞時還提供陪聊服務.
            而標准版中，是否解答于服務器無關的問題(例如某個軟件如何使用), 視客服心情而定.
        </p>

        <p>
            <? foreach ($rpL["admin-list"] as $adminID => $admin): ?>
                <? $adminInfo = "{$admin['description']}<br />QQ: {$admin['qq']}<br />E-mail: {$admin['email']}"; ?>
                <a class="admin" target="_blank" href="<?= $admin["url"]; ?>" rel="popover"
                   data-content="<?= $adminInfo; ?>" data-original-title="客服：<?= $admin["name"]; ?>">
                    <img alt="<?= $admin["name"]; ?>" src="<?= rpTools::gravatarURL($admin["email"], 48); ?>">
                </a>
            <? endforeach; ?>
        </p>

        <p>
            客服郵箱：<code><i class="icon-envelope"></i><?= $rpCfg["AdminsEmail"]; ?></code>
        </p>
        <ul class="left-tabs">
            <?= l("contact.list"); ?>
        </ul>
    </section>

<? lpTemplate::outputFile($rpL->file("template/agreement.php")); ?>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>