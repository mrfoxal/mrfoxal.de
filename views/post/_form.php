<?php

use app\components\UserPermissions;
use app\enums\AllowComments;
use app\enums\PostStatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use app\assets\MarkdownEditorAsset;
use app\models\category\Category;
use app\models\Material;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */
/* @var $form yii\widgets\ActiveForm */

MarkdownEditorAsset::register($this);

if (!is_array($model->form_tags) && !$model->isNewRecord) {
    $model->form_tags = ArrayHelper::map($model->tags, 'name', 'name');
} else {
    $model->form_tags = [];
}

?>

<div class="post-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row">
        <div class="row">
            <div class="col">
                <div class="form-group col-md-8">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="col">
                <div class="form-group col-md-4">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'type_id')->dropDownList(Material::MATERIAL_MAPPING, ['id'=>'type-id']) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'category_id')->widget(DepDrop::class, [
                    'data' => ArrayHelper::map(Category::getAllCategories($model->type_id ?? Material::MATERIAL_POST_ID), 'id', 'name'),
                    'options' => ['id'=>'category-id'],
                    'pluginOptions'=>[
                        'depends'=>['type-id'],
                        'placeholder' => 'Wählen Sie eine Kategorie',
                        'url' => Url::to(['/post/categories-list'])
                    ]
                ]); ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="col-md-6">
                <?= $form->field($model, 'preview_img')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-6">
                <?php if (UserPermissions::canAdminPost()) : ?>
                    <?= $form->field($model, 'form_tags')->widget(
                        Select2::class,
                        [
                            'options'       => [
                                'placeholder' => 'Tag finden...',
                                'multiple'    => true,
                            ],
                            'data'          => $model->form_tags,
                            'pluginOptions' => [
                                'tags'               => true,
                                'tokenSeparators'    => [','],
                                'minimumInputLength' => 2,
                                'maximumInputLength' => 20,
                                'allowClear'         => true,
                                'initSelection'      => new JsExpression(
                                    '
                function (element, callback) {
                    var data = [];
                    $(element.val()).each(function () {
                        data.push({id: this, text: this});
                    });
                    callback(data);
                }
            '
                                ),
                                'ajax'               => [
                                    'url'      => Url::to(['tag/search']),
                                    'dataType' => 'json',
                                    'data'     => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ],
                        ]
                    );
                    ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="col-md-12">
                <?= $form->field(
                    $model,
                    'content',
                    [
                        'template' => "{label}\n{error}\n{input}\n{hint}"
                    ]
                )->textarea(['class' => 'markdown-editor']) ?>
            </div>

            <?= \app\widgets\UploadList::widget() ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'status_id')->dropDownList(PostStatus::getList()) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'allow_comments')->dropDownList(AllowComments::getList()) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'show_share_buttons')->dropDownList(['1' => 'Ja', '0' => 'Nein']) ?>
            </div>
        </div>
        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'show_post_details')->dropDownList(['1' => 'Ja', '0' => 'Nein']) ?>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <?= Html::submitButton(
                    'Speichern',
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                ) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
