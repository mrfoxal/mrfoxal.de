<?php

namespace app\tests\models;

use app\enums\UserStatus;
use app\models\user\User;
use app\fixtures\UserFixture;

/**
 * Class UserTest
 *
 * @package app\tests\models
 */
class UserTest extends \Codeception\Test\Unit
{

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('test');
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('test'));
        expect($user->id)->equals(1);
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findByUsername('test');

        expect($user->username)->equals('test');
        expect($user->status)->equals('10');
        expect($user->email)->equals('test@example.com');
        expect($user->created_at)->equals('1391885313');
        expect($user->updated_at)->equals('1391885313');

        expect_that($user->validateAuthKey('iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv'));
        expect_that($user->validatePassword('Test1234'));
    }
}
