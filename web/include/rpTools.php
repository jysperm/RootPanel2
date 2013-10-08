<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

class rpTools
{
    static public function escapePlantText($text)
    {
        return nl2br(str_ireplace(" ", "&nbsp;", htmlspecialchars($text)));
    }

    static public function gravatarURL($email, $size = 80)
    {
        return c("GravaterURL") . md5(strtolower(trim($email))) . "?s={$size}";
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
        f("lpLocale")->load(["tools"]);

        $timeDiff = time() - $time;
        if($timeDiff < -3600 * 24)
            return l("tools.niceTime.daysAfter", round($timeDiff / (-3600 * 24)));
        else if($timeDiff < -3600)
            return l("tools.niceTime.hoursAfter", round($timeDiff / (-3600)));
        else if($timeDiff < -60)
            return l("tools.niceTime.minutesAfter", round($timeDiff / -60));
        else if($timeDiff < 0)
            return l("tools.niceTime.secondsAfter", -$timeDiff);
        else if($timeDiff < 60)
            return l("tools.niceTime.secondsBefore", $timeDiff);
        else if($timeDiff < 3600)
            return l("tools.niceTime.minutesBefore", round($timeDiff / 60));
        else if($timeDiff < 3600 * 24)
            return l("tools.niceTime.hoursBefore", round($timeDiff / (3600)));
        else if($timeDiff < 3600 * 24 * 7)
            return l("tools.niceTime.daysBefore", round($timeDiff / (3600 * 24)));
        else if($timeDiff > (strtotime(gmdate("Y", time())) + 3600 * 11))
            return l("tools.niceTime.date", gmdate(l("tools.niceTime.date.1"), $time), gmdate(l("tools.niceTime.date.2"), $time));
        else
            return gmdate(l("tools.niceTime.date.full"), $time);
    }
}