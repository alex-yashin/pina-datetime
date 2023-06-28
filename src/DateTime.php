<?php

namespace PinaTime;

use DateTimeInterface;
use DateTimeZone;
use Pina\Config;

class DateTime extends \DateTime
{
    public function setUserTimeZone()
    {
        $this->setTimezone(static::getUserTimeZone());
    }

    public function setServerTimeZone()
    {
        $this->setTimezone(static::getServerTimeZone());
    }

    public function setMoscowTimeZone()
    {
        $this->setTimezone(new DateTimeZone('Europe/Moscow'));
    }

    public function formatAsDate()
    {
        $f = Config::get('datetime', 'date_format') ?? "d.m.Y";
        return $this->format($f);
    }

    public function formatAsDateTime()
    {
        $fDate = Config::get('datetime', 'date_format') ?? "d.m.Y";
        $fTime = Config::get('datetime', 'time_format') ?? "H:i:s";
        return $this->format($fDate.' '.$fTime);
    }

    public static function createFromUserFormat($format, $datetime): DateTime
    {
        $tz = static::getUserTimeZone();
        return static::createFromCustomFormat($format, $datetime, $tz);
    }

    public static function createFromServerFormat($format, $datetime): DateTime
    {
        $tz = static::getServerTimeZone();
        return static::createFromCustomFormat($format, $datetime, $tz);
    }

    public static function createFromCustomFormat($format, $datetime, DateTimeZone $tz): DateTime
    {
        $dt = static::createFromFormat($format, $datetime, $tz);
        return static::createFromDateTimeInterface($dt);
    }

    public static function createFromDateTimeInterface(DateTimeInterface $dt): DateTime
    {
        $r = new static();
        $r->setTimestamp($dt->getTimestamp());
        $r->setTimezone($dt->getTimezone());
        return $r;
    }

    protected static function getUserTimeZone(): DateTimeZone
    {
        $tz = Config::get('datetime', 'timezone') ?? TimeZone::get();
        return new DateTimeZone($tz);
    }

    protected static function getServerTimeZone(): DateTimeZone
    {
        return new DateTimeZone(TimeZone::get());
    }
}
