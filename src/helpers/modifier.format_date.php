<?php

use PinaTime\Date;

/**
 * @param $date
 * @param bool $useOffset
 * @return string
 * @throws Exception
 */
function smarty_modifier_format_date($date, $useOffset = true)
{
    return Date::format($date, $useOffset);
}
