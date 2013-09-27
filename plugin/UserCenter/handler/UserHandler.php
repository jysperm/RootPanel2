<?php

namespace lpPlugins\UserCenter;

class UserHandler extends \lpHandler
{
    /** @var  UserModel */
    private $model;

    public function __construct()
    {
        $this->model = $this->model("User");
    }

    public function signup()
    {
        if(!$this->isPost())
            return $this->render("signup");

        try {
            list($uname, $passwd, $email, $contact) = $this->post([
                "uname" => '/^[A-Za-z][A-Za-z0-9_]+$/',
                "passwd",
                "email" => '/^[A-Za-z0-9_\-\.\+]+@[A-Za-z0-9_\-\.]+$/',
                "contact"
            ]);

            if($this->model->byUName($uname)->data())
                throw new \lpHandlerException("userExists");

            if(in_array($uname, \lpPlugin::hook("pUserCenter.notAllowSignup", [])))
                throw new \lpHandlerException("notAllowSignup");

            $this->model->register($uname, $passwd, $email, $contact);

            \lpApp::goUrl("/");
        }
        catch(\lpHandlerException $e)
        {
            return $this->render("signup", [
                "error" => $e->getMessage()
            ]);
        }
    }

    public function login()
    {
        if(!$this->isPost())
            return $this->render("login");

        try {

        }
        catch(\lpHandlerException $e)
        {

        }


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

    public function logout()
    {
        \rpAuth::logout();
        \rpApp::goUrl("/");
    }


}
