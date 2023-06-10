<?php

use PinaTime\Date;
use PinaTime\Time;
use PinaTime\TimeZone;

/**
 * @param $date
 * @return string
 * @throws Exception
 */
function smarty_modifier_server_datetime($date)
{
    return Date::format($date, false) . ' ' . Time::format($date, false) . ' ' . TimeZone::get();
}
