<?php

namespace app\models\upload;

use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * Upload image form
 */
class UploadImageForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['imageFiles'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'png, jpg',
                'maxFiles' => 5,
                'maxSize' => 1024 * 1024
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'imageFiles'  => 'Bild',
        ];
    }

    /**
     * Upload image
     *
     * @return bool
     */
    public function upload(): bool
    {
        if ($this->validate()) {

            $path = 'uploads/';

            foreach ($this->imageFiles as $file) {

                $randomFileName = md5($file->baseName . rand());
                $hashName = $randomFileName . '.' . $file->extension;

                $model = new Upload();

                $model->created_at = time();
                $model->filename = Inflector::slug($file->baseName) . '.' . $file->extension;
                $model->hashname = $hashName;
                $model->filesize = $file->size;

                if ($file->saveAs($path . $hashName)) {
                    $model->save();
                }

            }

            return true;
        }

        return false;
    }
}
