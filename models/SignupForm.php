<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\user\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    /** @var string */
    public $username;

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            [
                'username', 'unique', 'targetClass' => User::class,
                'message'                           => 'Username ist bereits vergeben.'
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'unique', 'targetClass' => User::class,
                'message'                        => 'E-Mail wird bereits verwendet.'
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['captcha', 'required'],
            [
                ['captcha'], 'demi\recaptcha\ReCaptchaValidator',
                'secretKey' => Yii::$app->params['reCAPTCHA.secretKey'],
                'when'      => function ($model) {
                    /** @var $model self */
                    return !$model->hasErrors() && Yii::$app->user->isGuest;
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'password' => 'Passowrd',
            'email'    => 'Email',
            'captcha'  => 'Captcha',
        ];
    }

    /**
     * Signs user up
     *
     * @return User|null the saved model or null if saving fails
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();

        return $user;
    }
}
