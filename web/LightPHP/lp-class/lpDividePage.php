<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class lpDividePage
{
    private $rows, $rowPerPage, $curPage;
    private $pages;

    const splitter = "...";

    public function __construct($rows, $curPage, $rowPerPage = 30)
    {
        $this->rows = $rows;
        $this->curPage = $curPage;
        $this->rowPerPage = $rowPerPage;

        $this->pages = ceil($this->rows / $this->rowPerPage);
    }

    public function getPos()
    {
        return ($this->curPage - 1) * $this->rowPerPage;
    }

    static public function fromGET($name = "p")
    {
        return isset($_GET[$name]) ? intval($_GET[$name]) : 1;
    }

    public function getOutput($buttonMaker, $buttonNum = 2)
    {
        $maker = function ($page) use ($buttonMaker) {
            return $buttonMaker($page, $this->curPage);
        };

        lpTemplate::beginBlock();

        if($this->curPage - $buttonNum > 1) {
            echo $maker(1);
            echo $maker(self::splitter);
        }

        for($i = $this->curPage - $buttonNum; $i < $this->curPage; $i++) {
            if($i > 0)
                echo $maker($i);
        }
        echo $maker($this->curPage);
        for($i = $this->curPage + 1; $i <= $this->curPage + $buttonNum; $i++) {
            if($i <= $this->pages)
                echo $maker($i);
        }
        if($this->pages - $this->curPage > $buttonNum) {
            echo $maker(self::splitter);
            echo $maker($this->pages);
        }

        return lpTemplate::endBlock();
    }
}