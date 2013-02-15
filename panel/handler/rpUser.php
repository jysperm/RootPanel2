<?php

class rpUser extends lpHandler
{
    static function initCallBack()
    {
        global $lpApp;

        $lpApp->auth()->cbSucceed = function()
        {
            global $lpApp;

            $row["lastlogintime"] = time();
            $row["lastloginip"] = rpTools::getIP();
            $row["lastloginua"] = $_SERVER["HTTP_USER_AGENT"];

            $q = new lpDBQuery($lpApp->getDB());
            $q("user")->where(["uname" => $lpApp->auth()->getUName()])->update($row);
        };
    }

    static function isAllowToPanel($user)
    {
        global $lpApp, $rpCfg;

        $q = new lpDBQuery($lpApp->getDB());
        $r = $q("user")->where(["uname" => $user])->top();
        if($r["type"] != rpTools::NO && !array_key_exists($user, $rpCfg["Admins"]))
            return true;
        else
            return false;
    }

    public function signup()
    {
        if(!$this->isPost())
        {
            global $rpROOT;
            lpTemplate::outputFile("{$rpROOT}/template/signup.php");
        }
        else
        {
            global $rpCfg, $rpM, $lpApp;

            $procError = function($str)
            {
                global $rpROOT;
                $tmp = new lpTemplate("{$rpROOT}/template/signup.php");

                $tmp->errorMsg = $str;
                $tmp->uname = $_POST["uname"];
                $tmp->email = $_POST["email"];
                $tmp->qq = $_POST["qq"];

                $tmp->output();

                exit(0);
            };

            if(!isset($_POST["uname"]) or !isset($_POST["email"]))
                $procError("请将信息填写完整");

            if(!preg_match('/[A-Za-z][A-Za-z0-9_]+/u', $_POST["uname"]) or
                !preg_match('/[A-Za-z0-9_\-\.\+]+@[A-Za-z0-9_\-\.]+/', $_POST["email"]))
                $procError($rpM["signupRule"]);

            if(in_array($_POST["uname"], $rpCfg["DenyUNames"]))
                $procError("该用户名不允许注册");

            $q = new lpDBQuery($lpApp->getDB());

            if($q("user")->where(["uname" => $_POST["uname"]])->top())
                $procError("该用户名已存在");

            $user = [
                "uname" => $_POST["uname"],
                "passwd" => $lpApp->auth()->cbDBHash($_POST["uname"], $_POST["passwd"]),
                "email" => $_POST["email"],
                "qq" => $_POST["qq"],
                "regtime" => time(),
                "type" => rpTools::NO,
                "pptppasswd" => "",
                "expired" => time() - 1
            ];

            $q("user")->insert($user);
            $token = ["token" => $lpApp->auth()->creatToken($_POST["uname"])];

            $lpApp->auth()->login($_POST["uname"], $token);

            $user["passwd"] = null;
            rpTools::makeLog($_POST["uname"], "注册了帐号", json_encode($user));

            $lpApp->goUrl("/panel/");
        }
    }

    public function login()
    {
        if(!$this->isPost())
        {
            global $rpROOT;
            lpTemplate::outputFile("{$rpROOT}/template/login.php");
        }
        else
        {
            global $lpApp;

            $procError = function($str)
            {
                global $rpROOT;

                $tmp=new lpTemplate("{$rpROOT}/template/login.php");

                $tmp->errorMsg = $str;
                $tmp->uname = $_POST["uname"];

                $tmp->output();

                exit();
            };

            if(!isset($_POST["uname"]) or !isset($_POST["passwd"]))
                $procError("请输入账号和密码");

            if($lpApp->auth()->login($_POST["uname"], ["raw" => $_POST["passwd"]]))
                $lpApp->goUrl(isset($_GET["next"])?$_GET["next"]:"/panel/");
            else
                $procError("用户名或密码错误");
        }
    }

    public function logout()
    {
        global $lpApp;

        $lpApp->auth()->logout();
        $lpApp->goUrl("/");
    }
}
