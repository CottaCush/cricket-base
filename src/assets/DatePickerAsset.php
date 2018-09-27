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
        self::ASSETS_PLUGINS_PATH . '/datepicker/bootstrap-datepicker3.standalone.min.css'
    ];

    public $js = [
        self::ASSETS_PLUGINS_PATH . '/datepicker/bootstrap-datepicker.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
