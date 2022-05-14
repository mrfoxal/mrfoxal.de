<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @package app\assets
 */
class VueAsset extends AssetBundle
{
    /** @var string */
    public $basePath = '@webroot';

    /** @var string */
    public $baseUrl = '@web';

    public function init()
    {
        parent::init();

        $this->js[] = 'js/app.js';

        $this->css[] = 'css/app.css';
    }
}