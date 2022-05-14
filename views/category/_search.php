<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\category\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">
    <div class="form-row">
        <?php $form = ActiveForm::begin(['action' => ['admin'], 'method' => 'get']); ?>
            <div class="row">
                <div class="col">
                    <div class="form-group col-md-8">
                        <?= $form->field($model, 'name') ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group col-md-3">
                        <?= $form->field($model, 'material_id')->dropDownList(\app\models\Material::MATERIAL_MAPPING) ?>
                    </div>
                </div>
                <div class="form-group col-md-1">
                    <?= Html::submitButton('Suchen', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
