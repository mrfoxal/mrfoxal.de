<?php

use app\helpers\Text;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
use app\models\Material;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$post = [
    'headline' => [
        'title' => $model->title,
    ],
    'href' => Url::to(['post/view', 'slug' => $model->slug]),
    'image' => $model->preview_img,
    'cutText' => Text::cut('[cut]', HtmlPurifier::process(Markdown::process($model->content, 'gfm'))),
    'link' => $model->link,
];

$post = json_encode($post);

$layout = json_encode($model->type_id === Material::MATERIAL_POST_ID ? 'row' : 'column');

?>

<m-list-view-item :layout='<?= $layout; ?>' :item='<?= $post; ?>'></m-list-view-item>
