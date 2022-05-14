<?php

namespace app\models\category;

use app\models\Material;
use yii\helpers\Inflector;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $material_id
 * @property string $description
 * @property int $order
 */
class Category extends Material
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'material_id'], 'required'],
            [['material_id', 'order'], 'integer'],
            [['name', 'slug', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'material_id' => 'Material ID',
            'description' => 'Beschreibung',
            'order' => 'Reihenfolge',
        ];
    }

    /**
     * Before save
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (empty($this->slug)) {
            $this->slug = Inflector::slug($this->name);
        }

        return true;
    }

    /**
     * Returns all categories for material id
     *
     * @return array
     */
    public static function getAllCategories(int $materialId): array
    {
        return Category::find()->andWhere(['material_id' => $materialId])->all();
    }
}
