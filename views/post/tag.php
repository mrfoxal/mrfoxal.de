<?php

use yii\helpers\Url;
use \yii\widgets\ListView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tag \app\models\Tag */

$tagName = $tag->name;

$this->title = sprintf('Posts mit dem Tag: %s', $tagName);

$this->registerMetaTag(['name' => 'title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['tag/' . $tag->slug], true)]);

$page = [
    'headline' => [
        'title' => $tagName,
        'icon' => 'fa fa-tags',
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>' :transparent="true" :list-view="true">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => 'Es wurden keine Posts gefunden.',
        'itemView' => '_view',
        'layout' => "{items}",
    ]); ?>

    <?= LinkPager::widget(['pagination' => $pagination]); ?>
</b-page>
