<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\user\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>

Hallo <?= Html::encode($user->username) ?>,

Folge dem Link, um dein Passwort zurückzusetzen:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
