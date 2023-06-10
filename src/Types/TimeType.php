<?php

namespace PinaTime\Types;

use Pina\App;
use Pina\Config;
use PinaTime\Controls\DateTimePicker;

class TimeType extends DateTimeType
{
    protected $serverFormat = 'H:i:s';
    protected $userFormat = "H:i:s";

    public function __construct()
    {
        parent::__construct();
        $this->userFormat = Config::get('datetime', 'time_format') ?? 'H:i:s';
    }

    protected function makeInput()
    {
        /** @var DateTimePicker $input */
        $input = App::make(DateTimePicker::class);
        $input->setFormat("H:mm:ss", false, true);
        return $input;
    }

    public function getSQLType()
    {
        return "time";
    }
}
