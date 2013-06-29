<?php

global $rpROOT, $rpCfg, $rpL;

$base = new lpTemplate("{$rpROOT}/template/base.php");

lpLocale::i()->load(["contact"]);

$base['title'] = "优质站点展示";
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
        $('#myCarousel').carousel();
    </script>
<? $base['endOfBody'] = lpTemplate::endBlock(); ?>

    <section>
        <header>优质站点展示</header>
        <div id="myCarousel" class="carousel slide">
            <!-- Carousel items -->
            <div class="carousel-inner" style="height: 500px;width: 870px">
                <div class="item active">
                    <img src="http://i.imgur.com/hDioltj.png" alt="jyprince.me">

                    <div class="carousel-caption">
                        <h4><a href="http://jyprince.me/">精英王子的博客</a></h4>

                        <p>该博客包含了精英王子的生活点滴和一些技术教程</p>
                    </div>
                </div>
                <div class="item">
                    <img src="http://i.imgur.com/pYyZM85.png" alt="im.librazy.org">

                    <div class="carousel-caption">
                        <h4><a href="http://im.librazy.org/">Librazy的博客</a></h4>

                        <p>Librazy是一个高中OI党</p>
                </div>
                <div class="item">
                    <img src="http://i.imgur.com/k554meP.jpg" alt="im.librazy.org">

                    <div class="carousel-caption">
                        <h4><a href="http://www.smxydxslt.com//">三明学院论坛</a></h4>

                        <p>福建省三明学院官方论坛，一个以学习，动漫为话题的综合SNS社区</p>
                    </div>
                </div>
            </div>
            <!-- Carousel nav -->
            <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>

        <div class="row-fluid">
            <ul class="thumbnails">
                <li class="span4">
                    <div class="thumbnail">
                        <img alt="300x200" style="width: 300px; height: 200px;" src="/style/300x200.png">

                        <div class="caption">
                            <h3>等待入住</h3>

                            <p>所有RP主机用户均可申请</p>
                        </div>
                    </div>
                </li>
                <li class="span4">
                    <div class="thumbnail">
                        <img alt="300x200" style="width: 300px; height: 200px;" src="/style/300x200.png">

                        <div class="caption">
                            <h3>等待入住</h3>

                            <p>所有RP主机用户均可申请</p>
                        </div>
                    </div>
                </li>
                <li class="span4">
                    <div class="thumbnail">
                        <img alt="300x200" style="width: 300px; height: 200px;" src="/style/300x200.png">

                        <div class="caption">
                            <h3>等待入住</h3>

                            <p>所有RP主机用户均可申请</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>

<? $base->output(); ?>