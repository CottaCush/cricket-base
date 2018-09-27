<?php

namespace CottaCush\Cricket\Assets;

/**
 * Class BootstrapPluginAsset
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Assets
 */
class BootstrapPluginAsset extends BaseCricketAsset
{
    public $css = [
        self::ASSETS_CSS_PATH . '/plugins/bootstrap/custom-bootstrap.css'
    ];

    public $js = [
        self::ASSETS_JS_PATH . '/bootstrap.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
