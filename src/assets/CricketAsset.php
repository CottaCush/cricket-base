<?php

namespace CottaCush\Cricket\Assets;

/**
 * Class BootstrapPluginAsset
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Assets
 */
class CricketAsset extends BaseCricketAsset
{
    public $css = [
        self::ASSETS_CSS_PATH . '/styles.css'
    ];

    public $depends = [
        'CottaCush\Cricket\Assets\BootstrapPluginAsset',
        'CottaCush\Cricket\Assets\DatePickerAsset',
        'CottaCush\Cricket\Assets\FontAwesomeAsset'
    ];
}
