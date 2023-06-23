<?php

namespace PinaTime;

use Exception;
use Pina\Config;
use \DateTime;

class Time
{
    /**
     * @param string|null $date
     * @param bool $useOffset
     * @return string
     * @throws Exception
     */
    public static function format(?string $date, bool $useOffset = true)
    {
        if (empty($date) || $date === '0000-00-00 00:00:00' || $date === "0000-00-00") {
            return '-';
        }

        if ($useOffset) {
            $tz = Config::get('datetime', 'timezone') ?? TimeZone::get();
            $date = TimeZone::convertServerTimezoneDateToUserTimezone($date, $tz);
        }

        $f = Config::get('datetime', 'format_time') ?? "H:i";
        $d = new DateTime($date);
        return $d->format($f);
    }

}
