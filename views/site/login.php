<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = 'Anmelden';

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <p class="hint-block">
            Wenn Sie Ihr Passwort vergessen haben, können Sie es <?= Html::a(
                'hier',
                ['site/request-password-reset']
            ) ?> zurücksetzen.
        </p>
        <div class="form-group">
            <?= Html::submitButton('Anmelden', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('Registrieren',['site/signup'],['class' => 'btn btn-light']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</b-page>
