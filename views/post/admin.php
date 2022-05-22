<?php

use app\enums\PostStatus;
use app\models\post\Post;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts (admin)';
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

    <p>
        <?= Html::a('Hinzufügen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'layout' => "{items}",
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                [
                    'attribute' => 'type_id',
                    'filter' => \app\models\Material::MATERIAL_MAPPING,
                    'value' => function ($model) {
                        return ArrayHelper::getValue(\app\models\Material::MATERIAL_MAPPING, $model->type_id);
                    },
                ],
                [
                    'attribute' => 'status_id',
                    'filter' => PostStatus::getList(),
                    'value' => static function (Post $model) {
                        return PostStatus::getLabel($model->status_id);
                    },
                ],
                [
                    'attribute' => 'hits',
                    'label' => 'Hits',
                    'value' => function ($model) {
                        return $model->hits;
                    }
                ],
                [
                    'attribute' => 'comments',
                    'label' => 'Kommentar',
                    'value' => function ($model) {
                        return $model->commentsCount;
                    }
                ],
                [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>',
                                    ['post/view', 'slug' => $model->slug]
                                );
                            },
                        ],
                ],

            ],
        ]
    ); ?>

    <?php Pjax::end(); ?>

    <?= LinkPager::widget(['pagination' => $pagination]); ?>
</b-page>
