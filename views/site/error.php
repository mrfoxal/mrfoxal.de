<?php

/* @var $this yii\web\View */

$this->title = 'Seite nicht gefunden';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => 'Fehler 404',
    ],
    'text' => 'Diese Seite konnte nicht gefunden werden.',
];

?>

<b-page v-bind='<?= json_encode($page); ?>'></b-page>
