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
        if (!$this->isPost())
            return $this->render("signup");

        try {
            list($uname, $passwd, $email, $contact) = $this->post([
                "uname" => '/^[A-Za-z][A-Za-z0-9_]+$/',
                "passwd",
                "email" => Validator::rx(lpEmail),
                "contact"
            ]);

            if ($this->model->byUName($uname)->data())
                throw new handlerException("userExists");

            if (in_array($uname, c("NotAllowSignup")))
                throw new handlerException("notAllowSignup");

            $this->model->register($uname, $passwd, $email, $contact);

            Application::goUrl("/");
        } catch (handlerException $e) {
            return $this->render("signup", [
                "error" => $e->getMessage()
            ]);
        }
    }

    public function login()
    {
        if (!$this->isPost())
            return $this->render("login");

        try {
            list($uname, $passwd) = $this->post([
                "uname",
                "passwd"
            ]);

            if (Validator::test(lpEmail, $uname))
                $user = $this->model->byEmail($uname);
            else
                $user = $this->model->byUName($uname);

            if (!$user->data())
                throw new handlerException("userNotExists");

            if (!$user->checkPasswd($passwd))
                throw new handlerException("invalidPasswd");

            /** @var Auth $session */
            $session = lpFactory::get("lpSession");
            $session->authenticated($user->id());
            $session->cookieRemember();

        } catch (handlerException $e) {
            return $this->render("login", [
                "error" => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        lpFactory::get("lpSession")->logout();
        Application::goUrl("/");
    }
}
