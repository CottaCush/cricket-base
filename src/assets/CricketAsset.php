<?php

namespace CottaCush\Cricket\Assets;

/**
 * Class CricketAsset
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Assets
 */
class CricketAsset extends BaseCricketAsset
{
    public $css = [
        self::ASSETS_CSS_PATH . '/styles.css'
    ];

    public $cjs = [
        self::ASSETS_JS_PATH . '/row-elements.js'
    ];

    public $depends = [
        'CottaCush\Cricket\Assets\FontAwesomeAsset',
        'yii\web\JqueryAsset'
    ];
}
