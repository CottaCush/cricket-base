<?php

namespace CottaCush\Cricket\Assets;

/**
 * Class BootstrapValidatorAsset
 * @author Taiwo Ladipo <taiwo.ladipo@cottacush.com>
 * @package CottaCush\Cricket\Assets
 */
class BootstrapValidatorAsset extends BaseCricketAsset
{
    public $css = [
        self::ASSETS_PLUGINS_PATH . '/bootstrap-validator/dist/validator.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
