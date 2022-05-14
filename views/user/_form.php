<?php

use app\components\UserPermissions;
use app\enums\UserStatus;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\user\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
        <?php if (UserPermissions::canAdminUsers()) : ?>
            <?= $form->field($model, 'status')->dropDownList(UserStatus::getList()) ?>
        <?php endif ?>

        <div class="form-group">
            <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
