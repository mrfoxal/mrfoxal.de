<?php

namespace app\models;

use app\models\user\User;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Material model
 *
 * @package app\models
 */
class Material extends ActiveRecord
{
    /** @var int */
    public const MATERIAL_POST_ID = 1;

    /** @var string */
    public const MATERIAL_POST_NAME = 'Post';

    /** @var array */
    public const MATERIAL_MAPPING = [
        self::MATERIAL_POST_ID => self::MATERIAL_POST_NAME,
    ];

    /** @var int Count of all comments */
    public $commentsCount;

    /**
     * Count hits
     *
     * @param string $materialName
     *
     * @return void
     */
    public function countHits(string $materialName): void
    {
        global $_COOKIE;

        $name_cookies = \Yii::$app->name . '-views-' . strtolower($materialName) . '-' . $this->id;
        $expire = 2592000; // days
        $slug = '/' . strtolower($materialName) . '/' . $this->id;
        $all_slug = [];

        if (isset($_COOKIE[$name_cookies])) {
            $all_slug = explode('|', $_COOKIE[$name_cookies]);
        }

        if (in_array($slug, $all_slug)) {
            false;
        } else {
            $all_slug[] = $slug;
            $all_slug = array_unique($all_slug);
            $all_slug = implode('|', $all_slug);
            $expire = time() + $expire;

            @setcookie($name_cookies, $all_slug, $expire);

            $this->updateCounters(["hits" => 1]);
        }
    }

    /**
     * Returns user
     *
     * @return \yii\db\ActiveQuery
     */
    protected function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
