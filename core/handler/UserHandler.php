<?php

class UserHandler extends lpHandler
{
    /** @var UserModel */
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
                "email" => lpValider::rx(lpEmail),
                "contact"
            ]);

            if($this->model->byUName($uname)->data())
                throw new lpHandlerException("userExists");

            //TODO: notAllowSignup

            $this->model->register($uname, $passwd, $email, $contact);

            App::goUrl("/");
        }
        catch(lpHandlerException $e)
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
            list($uname, $passwd) = $this->post([
                "uname",
                "passwd"
            ]);

            if(lpValider::test(lpEmail, $uname))
                $user = $this->model->byEmail($uname);
            else
                $user = $this->model->byUName($uname);

            if(!$user->data())
                throw new lpHandlerException("userNotExists");

            if(!$user->checkPasswd($passwd))
                throw new lpHandlerException("invalidPasswd");

            /** @var \lpSession $session */
            $session = lpFactory::get("lpSession");
            $session->authenticated($user->id());
            $session->cookieRemember();

        }
        catch(lpHandlerException $e)
        {
            return $this->render("login", [
                "error" => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        lpFactory::get("lpSession")->logout();
        App::goUrl("/");
    }
}
