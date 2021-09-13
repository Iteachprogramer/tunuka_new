<?php


namespace soft\widget\kartik;


use yii\base\InvalidArgumentException;
use yii\helpers\Html;

class DatePicker extends \kartik\widgets\DatePicker
{

    public $language = 'ru';

    public function run()
    {
        parent::run();
    }

    public function init()
    {
        parent::init();
        $this->normalizeValues();
        $css = <<<CSS
        .datepicker-dropdown{
            z-index: 9999!important;
        }
CSS;
        $this->view->registerCss($css, [], 'datepicker-dropdown-css');
    }

    private function normalizeValues()
    {
        if ($this->hasModel()) {
            $value = $this->value;
            if (!empty($value) && is_integer($value)) {

                if (!preg_match(Html::$attributeRegex, $this->attribute, $matches)) {
                    throw new InvalidArgumentException('Attribute name must contain word characters only.');
                }
                $attribute = $matches[2];
                $this->value = date('d.m.Y', $value);
                $this->model->$attribute = date('d.m.Y', $value);
            }
        }
        else{
            $value = $this->value;
            if (!empty($value) && is_integer($value)) {
                $this->value = date('d.m.Y', $value);
            }
        }
    }
}