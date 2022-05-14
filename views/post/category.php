<?php

use yii\helpers\Url;
use \yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category \app\models\category\Category */

$categoryName = $category->name;

$this->title = sprintf('Posts aus der Kategorie: %s', $categoryName);

$this->registerMetaTag(['name' => 'title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['category/' . $category->slug], true)]);

$page = [
    'headline' => [
        'title' => $categoryName,
        'icon' => 'fas fa-folder',
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
