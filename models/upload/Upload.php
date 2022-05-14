<?php

namespace app\models\upload;

use Yii;

/**
 * This is the model class for table "upload".
 *
 * @property int $id
 * @property string $filename
 * @property string $hashname
 * @property string $filesize
 * @property int $created_at
 */
class Upload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'filesize'], 'integer'],
            [['hashname', 'filename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'id',
            'filename'   => 'Datei name',
            'hashname'   => 'Hash name',
            'filesize'   => 'Größe',
            'created_at' => 'Hoch geladen am',
        ];
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        @unlink(Yii::$app->basePath . '/web/uploads/' . $this->hashname);

        return true;
    }
}
