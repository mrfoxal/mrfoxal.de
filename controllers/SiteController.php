<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

/**
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends Controller
{

    /**
     * Returns behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {

        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Returns actions
     *
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    /**
     * Action login page
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->getUser();

            if ($user !== null) {
                return $this->redirect(['user/view', 'id' => $user->getId()]);
            }

            return $this->goBack();
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Action logout user
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Action signup page
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user, Yii::$app->params['user.rememberMeDuration'])) {
                    return $this->redirect(['user/view', 'id' => $user->getId()]);
                }

            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Action request password reset page
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Du bekommst die Anweisungen per E-Mail.');

                return $this->goHome();
            }

            Yii::$app->getSession()->setFlash('error', 'Leider können wir dein Passwort nicht zurücksetzen.');
        }

        return $this->render('requestPasswordResetToken', ['model' => $model]);
    }

    /**
     * Action reset password page
     *
     * @param string $token
     *
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Neue Passwort wurde gespeichert.');

            return $this->goHome();
        }

        return $this->render('resetPassword', ['model' => $model]);
    }
}
