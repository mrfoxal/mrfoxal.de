<?php

use app\models\upload\Upload;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\upload\Upload */

$this->title = 'Datein hochladen';

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <div class="form-row">
        <div class="row">
            <div class="col">
                <div class="form-group col-md-8">
                    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <?= Html::submitButton(
                    'Speichern',
                    ['class' => 'btn btn-success']
                ) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'filename',
            'hashname',
            'created_at:datetime',
            [
                'attribute' => 'filesize',
                'format' => 'raw',
                'value' => static function (Upload $model) {
                    if (!$model->filesize) {
                        return Yii::$app->formatter->nullDisplay;
                    }

                    return Yii::$app->formatter->asShortSize($model->filesize, 2);
                },
                'contentOptions' => static function(Upload $model) {

                    if ($model->filesize >= 1024 * 1024) {
                    return ['class' => 'text-danger'];
                    }

                    if ($model->filesize > 1024 * 50) {
                        return ['class' => 'text-warning'];
                    }

                    if ($model->filesize <= 1024 * 50) {
                        return ['class' => 'text-success'];
                    }

                    return [
                        'class' => '',
                    ];
                },
            ],
            [
                'label' => 'Bild',
                'format' => 'raw',
                'value' => static function (Upload $model) {
                    if (!$model->hashname) {
                        return Yii::$app->formatter->nullDisplay;
                    }

                    return Html::a(
                        '<img 
                                title=" ' . Html::encode($model->filename) . ' "
                                alt=" ' . Html::encode($model->hashname) . ' "
                                src="/uploads/' . Html::encode($model->hashname) . '"
                                style="max-width: 88px; max-height: 50px;" />',
                        [
                            'upload/view', 'id' => $model->id
                        ]
                    );
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
            ],
        ],
        ]);
    ?>
</b-page>
