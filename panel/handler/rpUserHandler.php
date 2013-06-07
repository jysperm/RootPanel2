<?php

class rpUserHandler extends lpHandler
{
    public function signup()
    {
        lpLocale::i()->load(["signup", "contact"]);

        if(!$this->isPost()) {
            global $rpROOT;
            lpTemplate::outputFile("{$rpROOT}/template/user/signup.php");
        } else {
            global $rpCfg, $rpL;

            $procError = function ($str) {
                global $rpROOT;
                $tmp = new lpTemplate("{$rpROOT}/template/user/signup.php");

                $tmp->setValues([
                    "errorMsg" => $str,
                    "uname" => $_POST["uname"],
                    "email" => $_POST["email"],
                    "qq" => $_POST["qq"]
                ]);

                $tmp->output();
                exit(0);
            };

            if(!isset($_POST["uname"]) or !isset($_POST["email"]))
                $procError($rpL["signup.tips.incomplete"]);

            if(!preg_match('/^[A-Za-z][A-Za-z0-9_]+$/u', $_POST["uname"]) or
                !preg_match('/^[A-Za-z0-9_\-\.\+]+@[A-Za-z0-9_\-\.]+$/', $_POST["email"])
            )
                $procError($rpL["signup.rule"]);

            if(in_array($_POST["uname"], $rpCfg["NotAllowSignup"]))
                $procError($rpL["signup.tips.notAllowSignup"]);

            if(rpUserModel::find(["uname" => $_POST["uname"]]))
                $procError($rpL["signup.tips.userExists"]);

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
        lpLocale::i()->load(["contact", "login"]);

        if(!$this->isPost())
        {
            global $rpROOT;
            lpTemplate::outputFile("{$rpROOT}/template/user/login.php");
        }
        else
        {
            global $rpL;

            $procError = function ($str)
            {
                global $rpROOT;
                $tmp = new lpTemplate("{$rpROOT}/template/user/login.php");

                $tmp->setValues([
                    "errorMsg" => $str,
                    "uname" => $_POST["uname"],
                ]);

                $tmp->output();
                exit();
            };

            if(!isset($_POST["uname"]) or !isset($_POST["passwd"]))
                $procError($rpL["login.tips.noInput"]);

            if(rpAuth::login($_POST["uname"], ["raw" => $_POST["passwd"]]))
                rpApp::goUrl(isset($_GET["next"]) ? $_GET["next"] : "/panel/");
            else
                $procError($rpL["login.tips.passwdError"]);
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
        {
            global $lpCfg;

            setcookie($k, $v, time() + $lpCfg["lpTrackAuth"]["Limit"], "/");
        }

        if(isset($_GET["goUrl"]))
            rpApp::goUrl($_GET["goUrl"]);
        else
            rpApp::goUrl("/panel/");
    }
}
