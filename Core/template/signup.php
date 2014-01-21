<? ob_start(); ?>
    <header>注册</header>
    <form method="post" role="form" class="form-horizontal">
        <div class="form-group">
            <label for="username" class="col-sm-2 col-md-offset-1 control-label">用户名</label>
            <div class="col-sm-5">
                <input id="username" type="text" name="username" required="required" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 col-md-offset-1 control-label">邮箱</label>
            <div class="col-sm-5">
                <input id="email" type="email" name="email" required="required" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="passwd" class="col-sm-2 col-md-offset-1 control-label">密码</label>
            <div class="col-sm-5">
                <input id="passwd" type="password" name="passwd" required="required" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="passwd2" class="col-sm-2 col-md-offset-1 control-label">重复</label>
            <div class="col-sm-5">
                <input id="passwd2" type="password" name="passwd2" required="required" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3">
                <button type="submit" class="btn btn-lg btn-primary">注册</button>
            </div>
        </div>
    </form>
<? $body = ob_get_clean(); ?>

<? ob_start(); ?>
    <div class="row">
        <header>已有帐号？</header>
        <a href="/user/login" class="btn btn-lg btn-success">登录</a>
    </div>
<? $sidebar = ob_get_clean(); ?>

<?php
\LightPHP\View\PHPTemplate::outputFile(__DIR__ . "/layout.php", [
    "title" => "注册",
    "body" => $body,
    "sidebar" => $sidebar
]);
