<?php

namespace CottaCush\Cricket\Assets;

/**
 * Class DatePickerAsset
 * @package app\modules\reports\assets
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @author Olawale Lawal <wale@cottacush.com>
 */
class DatePickerAsset extends BaseCricketAsset
{
    public $css = [
        'datepicker/bootstrap-datepicker3.standalone.min.css'
    ];

    public $js = [
        'datepicker/bootstrap-datepicker.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
