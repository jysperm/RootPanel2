<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $this["title"];?> | <?= l("app.name");?></title>
    <link rel="stylesheet" href="/Core/static/library/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/Core/static/style/layout.css">
</head>
<body>
<header class="navbar-fixed-top">
    <div class="container">
        <nav role="navigation" class="navbar navbar-default navbar-inverse">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a href="/" class="navbar-brand">爱用工具</a>
            </div>
            <div id="navbar-collapse-1" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?= $this["topnav"];?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <? if($this["user"]->data()):?>
                        <li><a href="/user/settings"><?= $this["user"]["username"];?></a></li>
                        <li><a href="/user/logout"><?= l("word.logout");?></a></li>
                    <? else:?>
                        <li><a href="/user/signup"><?= l("word.signup");?></a></li>
                        <li><a href="/user/login"><?= l("word.login");?></a></li>
                    <? endif;?>
                </ul>
            </div>
        </nav>
    </div>
</header>
<div id="content" class="container">
    <div class="row">
        <div class="col-md-9">
            <?= $this["content"];?>
        </div>
        <div id="sidebar" class="col-md-3">
            <?= $this["sidebar"];?>
        </div>
    </div>
</div>
<div id="footer">
    <script src="/Core/static/library/jquery/jquery.min.js"></script>
    <script src="/Core/static/library/bootstrap/bootstrap.min.js"></script>
    <script>
        $(function() {
            $('nav a').each(function(index) {
                if($('nav a')[index].pathname == location.pathname)
                    $($('nav a')[index]).parent().addClass('active')
            });
        });
    </script>
</div>
</body>
</html>