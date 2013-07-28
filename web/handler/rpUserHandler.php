<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpUserHandler extends lpHandler
{
    public function signup()
    {
        if(!$this->isPost())
        {
            lpTemplate::outputFile(rpROOT . "/template/user/signup.php");
        }
        else
        {
            f("lpLocale")->load("signup");

            $procError = function ($str) {
                lpTemplate::outputFile(rpROOT . "/template/user/signup.php", [
                    "errorMsg" => $str,
                    "uname" => $_POST["uname"],
                    "email" => $_POST["email"],
                    "qq" => $_POST["qq"]
                ]);
                exit(0);
            };

            if(!isset($_POST["uname"]) or !isset($_POST["email"]))
                $procError(l("signup.tips.incomplete"));

            if(!preg_match('/^[A-Za-z][A-Za-z0-9_]+$/', $_POST["uname"]) or
                !preg_match('/^[A-Za-z0-9_\-\.\+]+@[A-Za-z0-9_\-\.]+$/', $_POST["email"])
            )
                $procError(l("signup.rule"));

            if(in_array($_POST["uname"], c("NotAllowSignup")))
                $procError(l("signup.tips.notAllowSignup"));

            if(rpUserModel::find(["uname" => $_POST["uname"]]))
                $procError(l("signup.tips.userExists"));

            $user = [
                "uname" => $_POST["uname"],
                "passwd" => rpAuth::dbHash($_POST["uname"], $_POST["passwd"]),
                "email" => $_POST["email"],
                "qq" => $_POST["qq"],
                "regtime" => time(),
                "type" => rpUserModel::NO,
                "settings" => ["pptppasswd" => "", "nginxextconfig" => "", "apache2extconfig" => ""],
                "expired" => time() - 1
            ];

            rpUserModel::insert($user);
            rpAuth::login($_POST["uname"], ["raw" => $_POST["passwd"]]);

            $user["passwd"] = null;
            unset($user["settings"]);
            unset($user["expired"]);
            rpLogModel::log($_POST["uname"], "log.type.signup", [], $user);

            rpApp::goUrl("/panel/");
        }
    }

    public function login()
    {
        if(!$this->isPost())
        {
            lpTemplate::outputFile(rpROOT . "/template/user/login.php");
        }
        else
        {
            f("lpLocale")->load(["login"]);

            $procError = function($str) {
                lpTemplate::outputFile(rpROOT . "/template/user/login.php", [
                    "errorMsg" => $str,
                    "uname" => $_POST["uname"],
                ]);
                exit();
            };

            if(!isset($_POST["uname"]) or !isset($_POST["passwd"]))
                $procError(l("login.tips.noInput"));

            if(rpAuth::login($_POST["uname"], ["raw" => $_POST["passwd"]]))
                rpApp::goUrl(isset($_GET["next"]) ? $_GET["next"] : "/panel/");
            else
                $procError(l("login.tips.passwdError"));
        }
    }

    public function logout()
    {
        rpAuth::logout();
        rpApp::goUrl("/");
    }

    public function setCookie()
    {
        foreach($_GET as $k => $v)
            setcookie($k, $v, time() + f("lpConfig.lpCfg")["CookieLimit"], "/");

        if(isset($_GET["goUrl"]))
            rpApp::goUrl($_GET["goUrl"]);
        else
            rpApp::goUrl("/panel/");
    }
}
