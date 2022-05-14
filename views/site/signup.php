<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = 'Registrieren';

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="captcha">
                <?= $form->field($model, 'captcha', ['enableAjaxValidation' => false])->label(false)
                     ->widget('demi\recaptcha\ReCaptcha', ['siteKey' => Yii::$app->params['reCAPTCHA.siteKey']]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(
                    'Registrieren',
                    ['class' => 'btn btn-primary', 'name' => 'signup-button']
                ) ?>
                <?= Html::a(
                    'Anmelden',
                    ['site/login'],
                    ['class' => 'btn btn-light']
                ) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</b-page>

