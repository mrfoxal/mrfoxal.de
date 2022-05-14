<?php

use yii\helpers\Html;
use app\components\UserPermissions;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = 'Ändern';

$this->params['breadcrumbs'][] = ['label' => 'Posts (admin)', 'url' => ['admin']];
$this->params['breadcrumbs'][] = 'Ändern';

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <i class="fa fa-check"></i>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?= $this->render('_form', ['model' => $model]) ?>
</b-page>
