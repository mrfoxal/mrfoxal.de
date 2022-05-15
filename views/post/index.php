<?php

use yii\helpers\Url;
use \yii\widgets\ListView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::$app->params['site']['name'];

$this->registerMetaTag(['name' => 'title', 'content' => \Yii::$app->params['site']['name']]);
$this->registerMetaTag(['name' => 'description', 'content' => \Yii::$app->params['site']['description']]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1']);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(\Yii::$app->params['site']['url'])]);

$postFilter = [
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
];

$postFilter = json_encode($postFilter);

$showPostFilter = $dataProvider->getTotalCount() >= 5;

?>

<b-page :transparent="true" :list-view="true">
    <m-material-filter v-if='<?= json_encode($showPostFilter); ?>' :items='<?= $postFilter ?>'></m-material-filter>

    <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => 'Es wurden keine Posts gefunden.',
            'itemView' => '_view',
            'layout' => "{items}",
        ]);
    ?>

    <?= LinkPager::widget(['pagination' => $pagination]); ?>
</b-page>
