<?php

use \yii\widgets\ListView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $page array */

$filter = [
    'show' => $dataProvider->getTotalCount() >= 5,
    'items' => [
        [
            'icon' => 'fa fa-clock',
            'label' => 'Neu',
            'url' => '/post/index',
        ],
        [
            'icon' => 'fa fa-eye',
            'label' => 'Beliebt',
            'url' => '/post/index/1',
        ],
        [
            'icon' => 'fa fa-comments',
            'label' => 'Diskutiert',
            'url' => '/post/index/2',
        ],
    ],
];

$this->title = $page['title'];

$this->registerMetaTag(['name' => 'title', 'content' => $page['meta']['title']]);
$this->registerMetaTag(['name' => 'description', 'content' => $page['meta']['description']]);
$this->registerMetaTag(['name' => 'robots', 'content' => $page['meta']['description']]);

$this->registerLinkTag(['rel' => 'canonical', 'href' => $page['canonical']]);

$headline = ['headline' => $page['headline'] ?? []];

?>

<b-page v-bind='<?= json_encode($headline); ?>' :transparent="true" :list-view="true">
    <m-material-filter v-if='<?= json_encode($filter['show']); ?>' :items='<?= json_encode($filter['items']) ?>'></m-material-filter>

    <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => 'Es wurden keine Posts gefunden.',
            'itemView' => '_view',
            'layout' => "{items}",
        ]);
    ?>

    <?= LinkPager::widget(['pagination' => $pagination]); ?>
</b-page>
