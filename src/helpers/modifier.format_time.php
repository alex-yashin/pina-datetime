<?php

use PinaTime\Time;

/**
 * @param $date
 * @param bool $useOffset
 * @return string
 * @throws Exception
 */
function smarty_modifier_format_time($date, $useOffset = true)
{
    return Time::format($date, $useOffset);
}
