<?php

use PinaTime\Date;

function smarty_modifier_format_date($date, $useOffset = true)
{
    return Date::format($date, $useOffset);
}
