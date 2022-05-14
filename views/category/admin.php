<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\category\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategorien (admin)';

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <div>
        <?= Html::a('Erstellen', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'slug',
            [
                'attribute' => 'material_id',
                'filter' => \app\models\Material::MATERIAL_MAPPING,
                'format' => 'text',
                'content' => function ($data) {
                    return ArrayHelper::getValue(\app\models\Material::MATERIAL_MAPPING, $data->material_id);
                },
            ],
            'order',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</b-page>
