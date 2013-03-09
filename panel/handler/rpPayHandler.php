<?php

class rpPayHandler extends lpHandler
{
    public function __invoke()
    {
        global $rpROOT;
        lpTemplate::outputFile("{$rpROOT}/template/pay/pay.php");
    }

    public function free()
    {
        if(!$this->isPost())
        {
            global $rpROOT;
            lpTemplate::outputFile("{$rpROOT}/template/pay/pay-free.php");
        }
        else
        {
            global $rpCfg, $rpROOT, $msg;

            if(!rpAuth::login())
                die("未登录");
            if(!isset($_POST["content"]))
                die("参数不全");

            $_POST["content"] = htmlentities($_POST["content"]);

            $mailer = new lpSmtp();
            $user = rpApp::q("user")->where(["uname" => rpAuth::uname()])->top();


            $mailTitle = $user["uname"] . "-RP主机试用申请({$rpCfg["NodeID"]})";
            $mailBody = "{$user["email"]}\n\n{$_POST['content']}";

            $mailer->send(array_values($rpCfg["Admins"])[0]["email"], $mailTitle, $mailBody);

            rpTools::makeLog($user["uname"], "填写试用申请", $_POST['content']);

            $tmp = new lpTemplate("{$rpROOT}/template/base.php");

            echo $msg["requstSendOk"];

            $tmp->output();
        }
    }
}