<?php

namespace app\commands;

use Yii;
use app\components\UserPermissions;
use app\models\user\User;
use yii\base\InvalidParamException;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class RbacController
 *
 * @package app\commands
 */
class RbacController extends Controller
{

    /**
     * @return int
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {

        if (!$this->confirm('Are you sure? It will re-create permissions tree.')) {
            return ExitCode::OK;
        }

        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $adminPost = $auth->createPermission(UserPermissions::ADMIN_POST);
        $adminPost->description = 'Administrate posts';
        $auth->add($adminPost);

        $adminUsers = $auth->createPermission(UserPermissions::ADMIN_USERS);
        $adminUsers->description = 'Administrate users';
        $auth->add($adminUsers);

        $adminCategory = $auth->createPermission(UserPermissions::ADMIN_CATEGORY);
        $adminCategory->description = 'Administrate categories';
        $auth->add($adminCategory);

        $adminUpload = $auth->createPermission(UserPermissions::ADMIN_UPLOAD);
        $adminUpload->description = 'Administrate uploads';
        $auth->add($adminUpload);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';

        $auth->add($admin);
        $auth->addChild($admin, $adminUsers);
        $auth->addChild($admin, $adminPost);
        $auth->addChild($admin, $adminCategory);
        $auth->addChild($admin, $adminUpload);

        return ExitCode::OK;
    }

    /**
     * @param $role
     * @param $username
     *
     * @throws \Exception
     */
    public function actionAssign($role, $username)
    {

        $user = User::find()->where(['username' => $username])->one();

        if (!$user) {
            throw new InvalidParamException("There is no user \"$username\".");
        }

        $auth = Yii::$app->authManager;

        $roleObject = $auth->getRole($role);

        if (!$roleObject) {
            throw new InvalidParamException("There is no role \"$role\".");
        }

        $auth->assign($roleObject, $user->id);
    }
}
