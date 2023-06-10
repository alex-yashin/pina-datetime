<?php

namespace PinaTime;

class Helper
{

    public static function formatDatetime($date, $useOffset = true, $withTimezone = false)
    {
        $fDate = Date::format($date, $useOffset);
        if ($fDate === '-') {
            return '-';
        }

        $timezone = $withTimezone && !$useOffset ? TimeZone::get() : '';

        return $fDate . ' ' . Time::format($date, $useOffset) . ' ' . $timezone;
    }

}
