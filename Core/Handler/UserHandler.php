<?php

namespace RootPanel\Core\Handler;

use LightPHP\Core\Router;
use RootPanel\Core\Core\Application;
use RootPanel\Core\Core\PageHandler;
use RootPanel\Core\Model\UserModel;
use LightPHP\Tool\Validator;
use LightPHP\Core\Exception\HandlerException;
use LightPHP\Tool\Auth;

class UserHandler extends PageHandler
{
    /** @var UserModel */
    private $model;

    public function __construct()
    {
        $this->model = $this->model("User");
    }

    public function getSignup()
    {
        $this->render("signup");
    }

    public function postSignup()
    {
        try {
            list($username, $passwd, $email, $contact) = $this->post([
                "username" => '/^[A-Za-z][A-Za-z0-9_]+$/',
                "passwd",
                "email" => Validator::rx(Validator::Email),
                "contact"
            ]);

            if ($this->model->byUsername($username)->data())
                throw new HandlerException("userExists");

            if (in_array($username, c("NotAllowSignup")))
                throw new HandlerException("notAllowSignup");

            $this->model->register($username, $passwd, $email, $contact);

            Router::goUrl("/");
        } catch (handlerException $e) {
            $this->render("signup", [
                "error" => $e->getMessage()
            ]);
        }
    }

    public function getLogin()
    {
        return $this->render("login");
    }

    public function login()
    {
        try {
            list($username, $passwd) = $this->post([
                "username",
                "passwd"
            ]);

            if (Validator::test(Validator::Email, $username))
                $user = $this->model->byEmail($username);
            else
                $user = $this->model->byUsername($username);

            if (!$user->data())
                throw new handlerException("userNotExists");

            if (!$user->checkPasswd($passwd))
                throw new handlerException("invalidPasswd");

            $auth = Application::$auth;
            $auth->authenticated($user->id());
            $auth->cookieRemember();
        } catch (handlerException $e) {
            $this->render("login", [
                "error" => $e->getMessage()
            ]);
        }
    }

    public function getLogout()
    {
        Application::$auth->logout();
        Router::goUrl("/");
    }
}
