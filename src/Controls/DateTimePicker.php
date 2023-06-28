<?php


namespace PinaTime\Controls;


use Pina\App;
use Pina\Controls\FormInput;

class DateTimePicker extends FormInput
{
    protected $cl = '';
    protected $format = '';
    protected $hasDate = true;
    protected $hasTime = true;

    public function __construct()
    {
        $this->cl = uniqid('cm');
        $this->addClass($this->cl);
    }

    public function setFormat($format, bool $hasDate, bool $hasTime)
    {
        $this->format = $format;
        $this->hasDate = $hasDate;
        $this->hasTime = $hasTime;
    }

    protected function draw()
    {
        //https://robinherbots.github.io/Inputmask/#/documentation/datetime
        App::assets()->addScript("/vendor/inputmask/inputmask.min.js");

        $format = $this->convertFormat($this->format);

        App::assets()->addScriptContent(
            '<script>Inputmask("datetime", { inputFormat: "' . $format . '" }).mask(document.querySelectorAll(".' . $this->cl . ' input"));</script>'
        );

        return parent::draw();
    }

    protected function convertFormat($format)
    {
        $symbols = str_split($format);
        $r = '';
        foreach ($symbols as $symbol) {
            $r .= $this->convertFormatSymbol($symbol);
        }
        return $r;
    }

    protected function convertFormatSymbol($s)
    {
        switch ($s) {
            case 'j':
                return 'd';
            case 'd':
                return 'dd';
            case 'D':
                return 'ddd';
            case 'w':
                return 'dddd';

            //months
            case 'n':
                return 'm';
            case 'm':
                return 'mm';
            case 'M':
                return 'mmm';
            case 'F':
                return 'mmmm';

            //year
            case 'y':
                return 'yy';
            case 'Y':
                return 'yyyy';

            //hours 24 format only now
            case 'G':
                return 'H';
            case 'H':
                return 'HH';

            case 'i':
                return 'MM';
            case 's':
                return 'ss';
        }

        return $s;
    }
}