<?php

namespace app\models\user;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\user\User]].
 *
 * @see \app\models\user\User
 */
class UserQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
