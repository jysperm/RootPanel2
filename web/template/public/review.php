<?php

global $rpROOT, $rpCfg, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");

lpLocale::i()->load(["contact"]);

$base['title'] = "客户评价";
?>

<? lpTemplate::beginBlock(); ?>
    <section>
        <header>咨询</header>
        <ul class="nav-list">
            <li>邮件 admins@rpvhost.net</li>
            <?= $rpL["contact.list"];?>
        </ul>
    </section>
<? $base['sidebar'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <script type="text/javascript">
        var duoshuoQuery = {short_name: "<?= $rpCfg["duoshuoID"];?>"};
        (function () {
            var ds = document.createElement('script');
            ds.type = 'text/javascript';
            ds.async = true;
            ds.src = 'http://static.duoshuo.com/embed.js';
            ds.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0]
                || document.getElementsByTagName('body')[0]).appendChild(ds);
        })();
    </script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

    <section>
        <header>客户评价</header>
        <div class="ds-thread" data-thread-key="page-review" data-title="客户评价">
        </div>
    </section>

<? $base->output(); ?>