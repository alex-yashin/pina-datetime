<?php

namespace PinaTime;

use \DateTime;
use \DateTimeZone;
use Pina\App;

class TimeZone
{
    private static $timezone = null;

    public static function get(): string
    {
        if (is_null(self::$timezone)) {
            $tz = App::db()->one("SELECT TIMESTAMPDIFF(SECOND, UTC_TIMESTAMP, NOW())");
            if (empty($tz)) {
                self::$timezone = 'GMT';
            } else {
                $offsetTime = gmdate("H:i", abs($tz));
                self::$timezone = 'GMT' . ($tz > 0 ? '+' : '-') . $offsetTime;
            }
        }

        return self::$timezone;
    }

    /**
     * Конвертирует поданную дату (в таймзоне сервера) в дату в таймзоне пользователя
     * @param string $date
     * @param string $userTimezone
     * @return string
     * @throws \Exception
     */
    public static function convertServerTimezoneDateToUserTimezone(string $date, string $userTimezone): string
    {
        $serverTz = new DateTimeZone(self::get());
        $tz = new DateTimeZone($userTimezone);
        $newDate = new DateTime($date, $serverTz);
        $newDate->setTimezone($tz);
        return $newDate->format('Y-m-d H:i:s');
    }

    public static function getList()
    {
        $timezones = [];
        $timezoneIdentifiers = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $dt = new DateTime();
        foreach ($timezoneIdentifiers as $timezone_identifier) {
            $dt->setTimezone(new DateTimeZone($timezone_identifier));
            $offset = $dt->getOffset();
            $timezones[$offset][] = [
                'offset' => $offset,
                'gmt' => $dt->format('P'),
                'identifier' => $timezone_identifier
            ];
        }
        ksort($timezones);

        $timezoneList = [];
        foreach ($timezones as $timezone) {
            foreach ($timezone as $item) {
                $timezoneList[] = $item;
            }
        }

        return $timezoneList;
    }

}
