<?php

namespace app\models;

use app\enums\UserStatus;
use app\models\user\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'exist',
                'targetClass' => '\app\models\user\User',
                'filter'      => ['status' => UserStatus::STATUS_NOT_APPROVED],
                'message'     => 'Benutzer mit dieser E-Mail-Adresse existiert nicht.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(
            [
                'status' => UserStatus::STATUS_NOT_APPROVED,
                'email'  => $this->email,
            ]
        );

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return \Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                                         ->setFrom([\Yii::$app->params['noreplyEmail'] => \Yii::$app->name])
                                         ->setTo($this->email)
                                         ->setSubject('Passwort zurücksetzen ' . \Yii::$app->name)
                                         ->send();
            }
        }

        return false;
    }
}
