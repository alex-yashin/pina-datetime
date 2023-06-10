<?php

namespace PinaTime\Types;

use Pina\Controls\FormControl;
use Pina\Data\Field;
use PinaTime\TimeZone;
use Pina\Types\EnumType;

class TimeZoneType extends EnumType
{
    protected $context = [];

    public function __construct()
    {
        $this->variants = $this->makeVariants();
    }

    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    public function makeControl(Field $field, $value): FormControl
    {
        $this->variants = $this->makeVariants();
        return parent::makeControl($field, $value);
    }

    public function normalize($value, $isMandatory)
    {
        $this->variants = $this->makeVariants();
        return parent::normalize($value, $isMandatory);
    }

    protected function makeVariants(): array
    {
        $timezones = TimeZone::getList();
        $this->variants = [];
        foreach ($timezones as $timezone) {
            $this->variants[] = ['id' => $timezone['identifier'], 'title' => '(GTM ' . $timezone['gmt'] . ') ' . $timezone['identifier']];
        }
        return $this->variants;
    }

    public function getSQLType(): string
    {
        return "varchar(255)";
    }
}