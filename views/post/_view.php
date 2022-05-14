<?php

use app\helpers\Text;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$post = [
    'headline' => [
        'title' => $model->title,
    ],
    'href' => Url::to(['post/view', 'slug' => $model->slug]),
    'image' => $model->preview_img,
    'cutText' => Text::cut('[cut]', HtmlPurifier::process(Markdown::process($model->content, 'gfm'))),
];

$post = json_encode($post);

?>

<m-list-view-item :item='<?= $post; ?>'></m-list-view-item>
