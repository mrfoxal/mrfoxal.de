<?php

/* @var $this yii\web\View */
/* @var $model app\models\category\Category */

$this->title = 'Ändern';

$this->params['breadcrumbs'][] = ['label' => 'Kategorien','url'   => ['admin']];

$this->params['breadcrumbs'][] = 'Ändern';

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
