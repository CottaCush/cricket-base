<?php

namespace CottaCush\Cricket\Widgets;

use CottaCush\Yii2\Widgets\BaseWidget as Yii2BaseWidget;
use CottaCush\Cricket\Assets\DateRangePickerAsset;
use yii\helpers\Html;

/**
 * Class DateRangePickerWidget
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Widgets
 */
class DateRangePickerWidget extends Yii2BaseWidget
{
    public $action;
    public $startDate;
    public $endDate;

    public function run()
    {
        DateRangePickerAsset::register($this->view);
        echo Html::beginForm($this->action, 'get');
        echo Html::beginTag('div', ['class' => 'form-group cricket-date-range-filter']);
        echo Html::textInput(
            'startDate',
            $this->startDate,
            [
                'id' => 'startDate',
                'class' => 'form-control input-sm dateInput',
                'placeholder' => 'Start Date',
                'autocomplete' => 'off'
            ]
        );
        echo Html::tag('span', ' to ', ['class' => 'text-bold cricket-date-range-separator']);
        echo Html::textInput(
            'endDate',
            $this->endDate,
            [
                'id' => 'endDate',
                'class' => 'form-control input-sm dateInput',
                'placeholder' => 'End Date',
                'autocomplete' => 'off'
            ]
        );
        echo Html::submitButton('Filter', ['class' => 'btn btn-primary btn-sm filter-btn']);
        echo Html::endTag('div');
        echo Html::endForm();
    }
}