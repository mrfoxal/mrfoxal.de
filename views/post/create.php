<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = 'Hinzufügen';

$this->params['breadcrumbs'][] = ['label' => 'Posts (admin)', 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?= $this->render('_form', ['model' => $model]) ?>
</b-page>
