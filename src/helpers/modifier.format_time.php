<?php

use PinaTime\Time;

function smarty_modifier_format_time($date, $useOffset = true)
{
    return Time::format($date, $useOffset);
}
