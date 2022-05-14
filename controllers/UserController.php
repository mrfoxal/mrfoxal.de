<?php

namespace app\controllers;

use Yii;
use app\models\user\UserSearch;
use app\models\user\User;
use app\components\UserPermissions;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 *
 * @package app\controllers
 */
class UserController extends Controller
{
    /**
     * Behaviors
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['view', 'update'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['view', 'update'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['admin', 'create'],
                        'roles'   => [UserPermissions::ADMIN_USERS],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     */
    public function actionAdmin()
    {
        $searchModel = new UserSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Action user view profile
     *
     * @param integer $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        /** @var User $user */
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('Benutzer nicht gefunden.');
        }

        return $this->render('view', ['model' => $user]);
    }

    /**
     * Updates an existing User model.
     *
     * @param integer $id
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if (!UserPermissions::canEditUser($model)) {
            throw new ForbiddenHttpException('Sie können dieses Profil nicht bearbeiten.');
        }

        $model->scenario = UserPermissions::canAdminUsers() ? User::SCENARIO_ADMIN : User::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Finds the User model based on its primary key value.
     *
     * @param integer $id
     *
     * @return User the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): User
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Die angeforderte Seite existiert nicht.');
    }
}
