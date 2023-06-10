<?php


namespace PinaTime\Controls;


use Pina\App;
use Pina\Controls\FormInput;
use Pina\Language;
use Pina\ResourceManagerInterface;
use Pina\StaticResource\Script;
use Pina\StaticResource\Style;

use function Pina\__;

class DateTimePicker extends FormInput
{
    protected $cl = '';
    protected $pickerFormat = '';
    protected $hasDate = true;
    protected $hasTime = true;

    public function __construct()
    {
        $this->cl = uniqid('cm');
        $this->addClass($this->cl);
    }

    public function setFormat($format, bool $hasDate, bool $hasTime)
    {
        $this->pickerFormat = $format;
        $this->hasDate = $hasDate;
        $this->hasTime = $hasTime;
    }

    protected function draw()
    {
        $this->resources()->append(
            (new Script())->setSrc("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js")
        );
        $this->resources()->append(
            (new Style())->setSrc("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css")
        );
        $this->resources()->append(
            (new Script())->setSrc("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js")
        );

        $pickerSettings = [
            'format' => $this->pickerFormat,
            'time' => $this->hasTime,
            'date' => $this->hasDate,
            'lang' => Language::code(),
            'weekStart' => 1,
            'cancelText' => __('Отмена'),
        ];
        $pickerSettingsJson = json_encode($pickerSettings, JSON_UNESCAPED_UNICODE);
        $pickerSelector = '.' . $this->cl . ' input, input.' . $this->cl;

        $this->resources()->append(
            (new Script())->setContent("<script>$('$pickerSelector').bootstrapMaterialDatePicker($pickerSettingsJson)</script>")
        );

        return parent::draw();
    }

    /**
     *
     * @return ResourceManagerInterface
     */
    protected function resources()
    {
        return App::container()->get(ResourceManagerInterface::class);
    }

}