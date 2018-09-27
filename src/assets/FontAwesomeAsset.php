<?php

namespace CottaCush\Cricket\Assets;

/**
 * Class FontAwesomeAsset
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Assets
 */
class FontAwesomeAsset extends BaseCricketAsset
{
    public $css = [
        self::ASSETS_PLUGINS_PATH . '/font-awesome/css/font-awesome.min.css'
    ];

    public $productionCss = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
    ];
}
