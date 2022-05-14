<?php

use app\models\upload\Upload;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\upload\Upload */

$this->title = $model->filename;

$this->params['breadcrumbs'][] = ['label' => 'Datei hochladen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

\yii\web\YiiAsset::register($this);

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?= Html::a('Löschen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Löschen?',
                'method' => 'post',
            ],
        ]);
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'filename',
            'hashname',
            'filesize:shortsize',
            'created_at:datetime',
            [
                'attribute' => 'hashname',
                'format' => 'raw',
                'value' => static function (Upload $model) {
                    if (!$model->hashname) {
                        return Yii::$app->formatter->nullDisplay;
                    }

                    return '<img alt="" src="/uploads/' . Html::encode($model->hashname) . '" style="max-width: 100%;" />';
                },
            ],
        ],
    ]);
    ?>
</b-page>
