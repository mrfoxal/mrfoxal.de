<?php

use app\widgets\Avatar;

/* @var $this yii\web\View */
/* @var $model app\models\user\User */

$this->title = $model->username;

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?= Avatar::widget(['user' => $model, 'size' => 165]) ?>

    <?php if (isset(\Yii::$app->user->identity) && $model->id === \Yii::$app->user->identity->getId()) : ?>
        <p>Einfach mal was schönes machen.</p>
    <?php endif; ?>
</b-page>
