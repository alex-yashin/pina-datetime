<?php

namespace PinaTime\Types;

use Pina\App;
use Pina\Config;
use PinaTime\Controls\DateTimePicker;
use PinaTime\DateTime;
use Pina\TableDataGateway;
use Pina\Types\StringType;
use Pina\Types\ValidateException;

use function Pina\__;

/*
 * Эта дата переводит время между зонами
 */
class DateTimeDateType extends DateTimeType
{
    protected $userFormat = "d.m.Y";
    protected $serverFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        parent::__construct();
        $this->userFormat = Config::get('datetime', 'date_format') ?? 'd.m.Y';
    }

    protected function makeInput()
    {
        /** @var DateTimePicker $input */
        $input = App::make(DateTimePicker::class);
        $input->setFormat($this->userFormat, true, false);
        return $input;
    }

    public function normalize($value, $isMandatory)
    {
        $value = StringType::normalize($value, $isMandatory);
        if (is_null($value)) {
            return $value;
        }

        return $this->makeDateTime($value)->format($this->serverFormat);
    }

    protected function makeDateTime($value)
    {
        /** @var DateTime $d */
        $d = DateTime::createFromUserFormat($this->userFormat, $value);
        if (empty($d)) {
            throw new ValidateException(__("Укажите корректную дату"));
        }
        $d->setTime(0, 0, 0, 0);
        $d->setServerTimeZone();

        return $d;
    }

    public function getSQLType(): string
    {
        return "datetime";
    }

    public function filter(TableDataGateway $query, $key, $value): void
    {
        $fields = is_array($key) ? $key : [$key];
        if (!$query->hasAllFields($fields)) {
            return;
        }

        $d = DateTime::createFromUserFormat($this->userFormat, $value);
        if (empty($d)) {
            return;
        }

        $d->setTime(0, 0, 0, 0);
        $d->setServerTimeZone();
        $begin = $d->format($this->serverFormat);
        $end = $d->modify('+1 day')->format($this->serverFormat);

        $query->whereBetween($fields, $begin, $end);
    }

}
