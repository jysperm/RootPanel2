<?php

class rpUWSGIType extends rpVHostType
{
    public function meta()
    {
        return [
            "name" => "uWSGI(Python)",
            "description" => "uWSGI(Python)"
        ];
    }

    public function settingsHTML($old)
    {
        return <<< HTML

uWSGI Socket：
<input type="text" class="input-xxlarge" id="vhost-uwsgi-socket" name="vhost-uwsgi-socket" value="{$old["settings"]["socket"]}"/>

HTML;
    }

    public function defaultSettings()
    {
        return ["socket" => ""];
    }
}