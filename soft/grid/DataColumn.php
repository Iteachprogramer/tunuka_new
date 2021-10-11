<?php


namespace soft\grid;


use yii\helpers\Html;

class DataColumn extends \kartik\grid\DataColumn
{


    public function init()
    {
        if ($this->format == 'bool' && $this->filter === null) {

            $this->filter = [
                1 => 'Ha',
                0 => 'Yo`q',
            ];

        }
        parent::init();
    }


    protected function renderFilterCellContent()
    {
        if (is_array($this->filter)) {

            Html::addCssClass($this->filterInputOptions, 'custom-select');
            if (!isset($this->filterInputOptions['prompt'])) {
                $this->filterInputOptions['prompt'] = '---';
            }
        }

        return parent::renderFilterCellContent();
    }


}
