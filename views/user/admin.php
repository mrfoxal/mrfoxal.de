<?php

use app\enums\UserStatus;
use app\models\user\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\user\UserSearch */

$this->title = 'Benutzer';

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$page = [
    'headline' => [
        'title' => $this->title,
    ],
];

?>

<b-page v-bind='<?= json_encode($page); ?>'>
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns'      => [
                [
                    'format' => 'raw',
                    'label' => 'Benutzer',
                    'attribute' => 'username',
                    'value' => static function ($model) {
                        return Html::a(Html::encode($model->username), ['user/view', 'id' => $model->id]);
                    }
                ],
                'email:email',
                [
                    'attribute' => 'created_at',
                    'label'     => 'Mitglied seit',
                    'value'     => static function ($model) {
                        return Yii::$app->formatter->asDate($model->created_at);
                    }
                ],
                [
                    'attribute' => 'status',
                    'filter' => UserStatus::getList(),
                    'value' => static function (User $model) {
                        return UserStatus::getLabel($model->status);
                    },
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{update}'],
            ],
        ]
    ) ?>
</b-page>
