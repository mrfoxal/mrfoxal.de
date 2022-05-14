<?php

namespace app\fixtures;

use app\models\user\User;
use yii\test\ActiveFixture;

/**
 * User fixture
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
