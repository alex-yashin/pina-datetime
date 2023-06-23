<?php

namespace PinaTime;

class Helper
{

    /**
     * @param string|null $date
     * @param bool $useOffset
     * @param bool $withTimezone
     * @return string
     * @throws \Exception
     */
    public static function formatDatetime(?string $date, $useOffset = true, $withTimezone = false)
    {
        $fDate = Date::format($date, $useOffset);
        if ($fDate === '-') {
            return '-';
        }

        $timezone = $withTimezone && !$useOffset ? TimeZone::get() : '';

        return $fDate . ' ' . Time::format($date, $useOffset) . ' ' . $timezone;
    }

}
