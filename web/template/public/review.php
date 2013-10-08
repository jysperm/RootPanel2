<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["base", "contact"]);

$base = new lpTemplate(rpROOT . "/template/base.php");

$base['title'] = l("base.review");
?>

<? lpTemplate::beginBlock(); ?>
    <section>
        <header><?= l("contact.service");?></header>
        <ul class="nav-list">
            <li><?= l("contact.email");?> <?= c("AdminsEmail");?></li>
            <?= l("contact.list");?>
        </ul>
    </section>
<? $base['sidebar'] = lpTemplate::endBlock(); ?>

<? lpTemplate::beginBlock(); ?>
    <script type="text/javascript">
        var duoshuoQuery = {short_name: "<?= c("DuoshuoID");?>"};
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

<? lpTemplate::beginBlock(); ?>
    <section>
        <header><?= l("base.review");?></header>
        <div class="ds-thread" data-thread-key="page-review" data-title="><?= l("base.review");?>">
        </div>
    </section>
<? $base['content'] = lpTemplate::endBlock(); ?>

<? $base->output(); ?>