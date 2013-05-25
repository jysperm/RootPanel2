<?php

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
                "db" => lpFactory::get("PDO"),
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

    public function reply($data)
    {
        global $rpCfg;
        $isAdmin = lpFactory::get("rpUserModel")->isAdmin();
        $id = $this->data["id"];

        $reply = [
            "replyto" => $id,
            "time" => time(),
            "uname" => rpAuth::uname(),
            "content" => rpTools::escapePlantText($data["content"])
        ];

        $tkRow = [
            "lastchange" => time(),
            "lastreply" => rpAuth::uname(),
        ];

        $mailer = lpFactory::get("lpSmtp");
        $mailTitle = "TK Reply | {$rpCfg["NodeID"]} | " . rpAuth::uname() . " | {$this->data["title"]}";
        $mailBody = "{$reply["content"]}<br />";
        $mailBody .= "<a href='http://{$rpCfg["NodeList"][$rpCfg["NodeID"]]["domain"]}/ticket/view/{$id}/'># {$id} | {$this->data["title"]}</a>";

        rpTicketReplyModel::insert($reply);
        if($isAdmin)
        {
            rpLogModel::log($this->data['uname'], "log.type.adminReplyTicket", [$id, $id], $reply, rpAuth::uname());

            $tkRow["status"] = rpTicketModel::HODE;

            $mailer->send(rpUserModel::by("uname", $this->data["uname"])["email"], $mailTitle, $mailBody, lpSmtp::HTMLMail);
        }
        else
        {
            rpLogModel::log($this->data['uname'], "log.type.replyTicket", [$id, $id], $reply);

            $tkRow["status"] = rpTicketModel::OPEN;

            $mailTitle = "TK Reply | {$rpCfg["NodeID"]} | " . rpAuth::uname() . " | {$this->data["title"]}";

            $mailer->send($rpCfg["adminsEmail"], $mailTitle, $mailBody, lpSmtp::HTMLMail);
        }

        rpTicketModel::update(["id" => $id], $tkRow);
    }
}