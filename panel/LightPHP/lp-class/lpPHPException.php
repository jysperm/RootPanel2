<?php

class lpPHPException extends Exception
{
    protected $severity;
    protected $varList;

    public function  __construct($message = "", $code = 0, $severity = 1, $filename = __FILE__, $lineno = __LINE__, Exception $previous = null, $varList = [])
    {
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $lineno;
        $this->varList = $varList;

        parent::__construct($message, $code, $previous);
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function getVarList()
    {
        return $this->varList;
    }
}