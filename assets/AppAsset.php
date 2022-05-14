<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * App asset
 *
 * @package app\assets
 */
class AppAsset extends AssetBundle
{
    /** @var string */
    public $basePath = '@webroot';

    /** @var string */
    public $baseUrl = '@web';

    /** @var array */
    public $css = [];

    /** @var array */
    public $js = [
        'js/yiiscript.js',
    ];

    /** @var array */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\FontAwesomeAsset'
    ];
}
