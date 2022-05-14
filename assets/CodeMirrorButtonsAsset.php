<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Code mirror buttons asset
 *
 * @package app\assets
 */
class CodeMirrorButtonsAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@bower/codemirror-buttons';

    /** @var string[] */
    public $js = [
        'buttons.js',
    ];
}
