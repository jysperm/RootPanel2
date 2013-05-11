<?php

interface rpVHostType
{
    public function meta();
    public function settingsHTML($old);
    public function defaultSettings();
}