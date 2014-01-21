<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $this["title"]; ?> | <?= l("app.name"); ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="/Core/static/image/logo.png"/>
    <link rel="stylesheet" href="/Core/static/library/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/Core/static/style/layout.css">
</head>
<body>
<header class="navbar-fixed-top">
    <div class="container">
        <nav role="navigation" class="navbar navbar-default navbar-inverse">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span></button>
                <a href="/" class="navbar-brand">RootPanel</a>
            </div>
            <div id="navbar-collapse-1" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <?= $this["topnav"]; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <? if ($this["user"]->data()): ?>
                        <li><a href="/user/settings"><?= $this["user"]["username"]; ?></a></li>
                        <li><a href="/user/logout"><?= l("word.logout"); ?></a></li>
                    <? else: ?>
                        <li><a href="/user/signup"><?= l("word.signup"); ?></a></li>
                        <li><a href="/user/login"><?= l("word.login"); ?></a></li>
                    <? endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
<div class="container">
    <div class="row">
        <div id="body" class="col-md-9">
            <?= $this["body"]; ?>
        </div>
        <div id="sidebar" class="col-md-3">
            <?= $this["sidebar"]; ?>
        </div>
    </div>
</div>
<div id="footer">
    <script src="/Core/static/library/jquery/jquery.min.js"></script>
    <script src="/Core/static/library/bootstrap/bootstrap.min.js"></script>
    <script src="/Core/static/script/layout.js"></script>
</div>
</body>
</html>
