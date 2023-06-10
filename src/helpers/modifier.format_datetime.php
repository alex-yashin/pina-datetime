<?php

use PinaTime\Helper;

function smarty_modifier_format_datetime($date, $useOffset = true, $withTimezone = false)
{
    return Helper::formatDatetime($date, $useOffset, $withTimezone);
}
