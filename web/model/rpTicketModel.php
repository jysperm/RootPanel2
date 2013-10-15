<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpTicketModel extends lpPDOModel
{
    static protected $metaData = null;

    // 用户创建工单、用户回复工单
    const OPEN = "ticket.status.open";
    // 管理员回复工单，且等待用户回复
    const HODE = "ticket.status.hode";
    // 管理员将工单标记为完成
    const FINISH = "ticket.status.finish";
    // 工单被关闭
    const CLOSED = "ticket.status.closed";

    static protected function metaData()
    {
        if(!self::$metaData) {
            self::$metaData = [
                "db" => f("lpDBDrive"),
                "table" => "ticket",
                "engine" => "MyISAM",
                "charset" => "utf8",
                self::PRIMARY => "id"
            ];

            self::$metaData["struct"] = [
                "id" => ["type" => self::AI],
                "uname" => ["type" => self::VARCHAR, "length" => 256],
                "time" => ["type" => self::UINT],
                "title" => ["type" => self::TEXT],
                "content" => ["type" => self::TEXT],
                "onlyclosebyadmin" => ["type" => self::INT],
                "type" => ["type" => self::VARCHAR, "length" => 256],
                "status" => ["type" => self::VARCHAR, "length" => 256],
                "lastchange" => ["type" => self::UINT],
                "replys" => ["type" => self::INT],
                "lastreply" => ["type" => self::VARCHAR, "length" => 256]
            ];

            foreach(self::$metaData["struct"] as &$v)
                $v[self::NOTNULL] = true;
        }

        return self::$metaData;
    }

    static public function create($data)
    {
        $ticket = [
            "time" => time(),
            "title" => $data["title"],
            "type" => $data["type"],
            "lastchange" => time(),
            "replys" => 0,
            "lastreply" => rpAuth::uname(),
            "content" => $data["content"]
        ];

        $mailSender = function($id, $email) use($ticket) {
            $mailer = lpFactory::get("lpSmtp");
            $mailTitle = l("ticket.createMail.title", c("NodeID"), rpAuth::uname(), $ticket["title"]);
            $mailBody = l("ticket.createMail.body", $ticket["content"], c("NodeList")[c("NodeID")]["domain"], $id, $id, $ticket["title"]);

            $mailer->send($email, $mailTitle, $mailBody, lpSmtp::HTMLMail);
        };

        $id = null;
        if(lpFactory::get("rpUserModel")->isAdmin())
        {
            $users = explode(" ", trim(str_replace("  ", " ", $data["users"])));
            $ticket["status"] = rpTicketModel::HODE;

            foreach($users as $user)
            {
                $ticket["onlyclosebyadmin"] = $data["onlyclosebyadmin"] ? 1 : 0;
                $ticket["uname"] = $user;

                $id = rpTicketModel::insert($ticket);
                rpLogModel::log($user, "log.type.adminCreateTicket", [$id, $id], $ticket, rpAuth::uname());

                App::registerAtexit(function() use($mailSender, $id, $user) {
                    $mailSender($id, rpUserModel::by("uname", $user)["email"]);
                });
            }
        }
        else
        {
            $ticket["onlyclosebyadmin"] = 0;
            $ticket["uname"] = rpAuth::uname();
            $ticket["status"] = rpTicketModel::OPEN;

            $id = rpTicketModel::insert($ticket);
            rpLogModel::log(rpAuth::uname(), "log.type.createTicket", [$id, $id], $ticket);

            App::registerAtexit(function() use($mailSender, $id) {
                $mailSender($id, c("AdminsEmail"));
            });
        }
    }

    public function reply($data)
    {
        $id = $this->data["id"];

        $reply = [
            "replyto" => $id,
            "time" => time(),
            "uname" => rpAuth::uname(),
            "content" => $data["content"]
        ];

        $tkRow = [
            "lastchange" => time(),
            "lastreply" => rpAuth::uname(),
        ];

        $mailSender = function($email) use($reply, $id) {
            $mailer = lpFactory::get("lpSmtp");
            $mailTitle = l("ticket.replyMail.title", c("NodeID"), rpAuth::uname(), $this->data["title"]);
            $mailBody = l("ticket.replyMail.body", $reply["content"], c("NodeList")[c("NodeID")]["domain"], $id, $id, $this->data["title"]);

            $mailer->send($email, $mailTitle, $mailBody, lpSmtp::HTMLMail);
        };

        rpTicketReplyModel::insert($reply);

        if(lpFactory::get("rpUserModel")->isAdmin())
        {
            rpLogModel::log($this->data['uname'], "log.type.adminReplyTicket", [$id, $id], $reply, rpAuth::uname());

            $tkRow["status"] = rpTicketModel::HODE;
            rpTicketModel::update(["id" => $id], $tkRow);

            App::registerAtexit(function() use($mailSender) {
                $mailSender(rpUserModel::by("uname", $this->data["uname"])["email"]);
            });
        }
        else
        {
            rpLogModel::log($this->data['uname'], "log.type.replyTicket", [$id, $id], $reply);

            $tkRow["status"] = rpTicketModel::OPEN;
            rpTicketModel::update(["id" => $id], $tkRow);

            App::registerAtexit(function() use($mailSender) {
                $mailSender(c("AdminsEmail"));
            });
        }
    }

    public function close()
    {
        $id = $this->data["id"];

        rpTicketModel::update(["id" => $id], ["status" => self::CLOSED]);

        $mailSender = function($email) use($id) {
            $mailer = lpFactory::get("lpSmtp");
            $mailTitle = l("ticket.closeMail.title", c("NodeID"), rpAuth::uname(), $this->data["title"]);
            $mailBody = l("ticket.closeMail.body", c("NodeList")[c("NodeID")]["domain"], $id, $id, $this->data["title"]);

            $mailer->send($email, $mailTitle, $mailBody, lpSmtp::HTMLMail);
        };

        if(lpFactory::get("rpUserModel")->isAdmin())
        {
            rpLogModel::log($this->data['uname'], "log.type.adminCloseTicket", [$id, $id], [], rpAuth::uname());

            App::registerAtexit(function() use($mailSender) {
                $mailSender(rpUserModel::by("uname", $this->data["uname"])["email"]);
            });
        }
        else
        {
            rpLogModel::log(rpAuth::uname(), "log.type.closeTicket", [$id, $id], []);

            App::registerAtexit(function() use($mailSender) {
                $mailSender(c("AdminsEmail"));
            });
        }
    }

    public function finish()
    {
        $id = $this->data["id"];

        rpTicketModel::update(["id" => $id], ["status" => self::FINISH]);

        rpLogModel::log($this->data['uname'], "log.type.finishTicket", [$id, $id], [], rpAuth::uname());

        App::registerAtexit(function() use($id) {
            $mailer = lpFactory::get("lpSmtp");
            $mailTitle = l("ticket.closeMail.title", c("NodeID"), rpAuth::uname(), $this->data["title"]);
            $mailBody = l("ticket.closeMail.body", c("NodeList")[c("NodeID")]["domain"], $id, $id, $this->data["title"]);

            $mailer->send(rpUserModel::by("uname", $this->data["uname"])["email"], $mailTitle, $mailBody, lpSmtp::HTMLMail);
        });
    }
}