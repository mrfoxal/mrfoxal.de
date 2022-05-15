<?php

use app\components\UserPermissions;
use app\helpers\Text;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = Html::encode($model->title);

$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['/post/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'title', 'content' => $model->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1']);

$currentPage = Url::to(['post/view', 'slug' => $model->slug], true);

$this->registerLinkTag(['rel' => 'canonical', 'href' => $currentPage]);

/**
 * https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started
 * https://cards-dev.twitter.com/validator
 */
$this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
$this->registerMetaTag(['name' => 'twitter:site', 'content' => \Yii::$app->params['site']['twitter']]);
$this->registerMetaTag(['name' => 'twitter:domain', 'content' => \Yii::$app->params['site']['description']]);
$this->registerMetaTag(['name' => 'twitter:creator', 'content' => \Yii::$app->params['site']['twitter']]);
$this->registerMetaTag(['name' => 'twitter:url', 'content' => $currentPage]);
$this->registerMetaTag(['name' => 'twitter:title', 'content' => $model->title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $model->meta_description]);
$this->registerMetaTag(['name' => 'twitter:image:src', 'content' => $model->preview_img]);

/**
* https://ogp.me
*/
$this->registerMetaTag(['name' => 'og:type', 'content' => 'article']);
$this->registerMetaTag(['name' => 'og:title', 'content' => $model->title]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $model->meta_description]);
$this->registerMetaTag(['name' => 'og:url', 'content' => $currentPage]);
$this->registerMetaTag(['name' => 'og:site_name', 'content' => \Yii::$app->params['site']['name']]);
$this->registerMetaTag(['name' => 'og:locale', 'content' => Yii::$app->language]);
$this->registerMetaTag(['name' => 'og:image', 'content' => $model->preview_img]);
$this->registerMetaTag(['name' => 'og:image:width', 'content' => '806']);
$this->registerMetaTag(['name' => 'og:image:height', 'content' => '327']);
$this->registerMetaTag(['name' => 'og:image:alt', 'content' => $model->title]);

$post = [
    'headline' => [
        'title' => $model->title,
    ],
    'href' => Url::to(['post/view', 'slug' => $model->slug]),
    'image' => $model->preview_img,
    'content' => Text::hidecut('[cut]', HtmlPurifier::process(Markdown::process($model->content, 'gfm'))),
    'comments' => [
        'allowed' => $model->commentsAllowed(),
        'count' => $model->commentsCount,
    ],
    'edit' => [
        'can' => UserPermissions::canAdminPost(),
        'url' => Url::to(['post/update', 'id' => $model->id]),
    ],
    'created' => date('d.m.Y', $model->datecreate),
    'showDetails' => $model->show_post_details,
    'showShareButtons' => $model->show_share_buttons,
];

if (isset($model->category->name)) {
    $post['category'] = [
        'name' => $model->category->name,
        'href' => Url::to('/category/' . $model->category->slug),
    ];
}

if (!empty($model->tags)) {
    $post['tags'] = Text::getTagsList($model);
}


$post = json_encode($post);

?>

<b-page :transparent="true">
    <m-list-view-item :item='<?= $post; ?>'>
        <?php if ($model->commentsAllowed()) : ?>
            <?= $this->render('_comments', ['model' => $model]); ?>
        <?php endif; ?>
    </m-list-view-item>
</b-page>