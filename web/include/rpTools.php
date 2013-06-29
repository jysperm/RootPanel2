<?php

class rpTools
{
    static public function escapePlantText($text)
    {
        return nl2br(str_ireplace(" ", "&nbsp;", htmlspecialchars($text)));
    }

    static public function gravatarURL($email, $size = 80)
    {
        global $rpCfg;
        return $rpCfg["GravaterURL"] . md5(strtolower(trim($email))) . "?s={$size}";
    }

    public static function getIP()
    {
        if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        else
            return $_SERVER["REMOTE_ADDR"];
    }

    public static function niceTime($time)
    {
        $timeDiff = time() - $time;
        if($timeDiff < -3600 * 24)
            return round($timeDiff / (-3600 * 24)) . " 天后";
        elseif($timeDiff < -3600)
            return round($timeDiff / (-3600)) . " 小时后"; elseif($timeDiff < -60)
            return round($timeDiff / -60) . " 分后"; elseif($timeDiff < 0)
            return -$timeDiff . " 秒后"; elseif($timeDiff < 60)
            return $timeDiff . " 秒前"; elseif($timeDiff < 3600)
            return round($timeDiff / 60) . " 分前"; elseif($timeDiff < 3600 * 24)
            return round($timeDiff / (3600)) . " 小时前"; elseif($timeDiff < 3600 * 24 * 7)
            return round($timeDiff / (3600 * 24)) . " 天前"; elseif($timeDiff > (strtotime(gmdate("Y", time())) + 3600 * 11))
            return gmdate("m", $time) . " 月 " . gmdate("d", $time) . " 日"; else
            return gmdate("Y.m.d", $time);
    }
}