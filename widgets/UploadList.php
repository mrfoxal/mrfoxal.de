<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\upload\Upload;

/**
 * Renders upload list
 *
 * @package app\widgets
 */
class UploadList extends Widget
{
    /** @var array */
    public $options = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $images = Upload::find()->limit(5)->orderBy('created_at DESC')->all();

        if ($images) {
            echo '<div class="upload-images">';

            foreach ($images as $image) {
                echo '<img alt="' . $image['filename'] . '" title="' . $image['filename'] . '"';
                echo 'src="' . Yii::$app->params['site']['url'] . Yii::getAlias('@web') . '/uploads/' . $image['hashname'] . '" />';
            }

            echo '</div>';
        }

        return '';
    }
}
