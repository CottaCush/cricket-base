<?php

namespace CottaCush\Cricket\Assets;

/**
 * Class DateRangePickerAsset
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Assets
 */
class DateRangePickerAsset extends BaseCricketAsset
{
    public $js = [
        self::ASSETS_JS_PATH . '/date-range-picker.js'
    ];

    public $depends = [
        'CottaCush\Cricket\Assets\DatePickerAsset'
    ];
}
