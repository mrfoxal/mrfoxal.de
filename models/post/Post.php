<?php

namespace app\models\post;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\helpers\Inflector;
use app\enums\AllowComments;
use app\enums\PostStatus;
use app\models\Material;
use app\models\category\Category;
use app\models\Tag;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $slug
 * @property string  $content
 * @property integer $status_id
 * @property integer $datecreate
 * @property integer $dateupdate
 * @property integer $user_id
 * @property integer $hits
 * @property bool    $allow_comments
 * @property string  $meta_description
 * @property integer $category_id
 * @property integer $show_share_buttons
 * @property integer $show_post_details
 * @property integer $type_id
 * @property string  $link
 *
 * relations
 * @property Tag[] $tags
 * @property Category[] $category
 */
class Post extends Material
{
    /** @var array */
    public $form_tags;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'datecreate', 'dateupdate', 'user_id', 'hits', 'category_id'], 'required'],
            [['content', 'slug', 'preview_img', 'link'], 'string'],
            [
                [
                    'datecreate',
                    'dateupdate',
                    'user_id',
                    'hits',
                    'category_id',
                    'show_share_buttons',
                    'show_post_details',
                    'type_id',
                ],
                'integer'
            ],
            [['title'], 'string', 'max' => 69],
            [['show_share_buttons', 'show_post_details'], 'string', 'max' => 1],
            [['meta_description'], 'string', 'max' => 156],
            [['form_tags'], 'safe'],
            ['status_id', 'in', 'range' => PostStatus::getKeys()],
            ['allow_comments', 'in', 'range' => AllowComments::getKeys()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[Model::SCENARIO_DEFAULT] = [
            'title',
            'content',
            'allow_comments',
            'status_id',
            'meta_description',
            'slug',
            'form_tags',
            'category_id',
            'show_share_buttons',
            'show_post_details',
            'preview_img',
            'type_id',
            'link',
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'title'              => 'Überschrift',
            'content'            => 'Content',
            'status_id'          => 'Status',
            'datecreate'         => 'Datum der Veröffentlichung',
            'dateupdate'         => 'Datum der Aktualisierung',
            'user_id'            => 'Benutzer ID',
            'hits'               => 'Hits',
            'allow_comments'     => 'Kommentare erlauben',
            'meta_description'   => 'Beschreibung der Seite (meta-description)',
            'slug'               => 'Slug',
            'form_tags'          => 'Tags',
            'category_id'        => 'Kategorie',
            'show_share_buttons' => 'Block "Teilen" anzeigen',
            'show_post_details'  => 'Details anzeigen',
            'preview_img'        => 'Vorschaubild',
            'type_id'            => 'Type',
            'link'               => 'Link',
        ];
    }

    /**
     * @param bool $insert
     * 
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->user_id = Yii::$app->user->id;
            $this->datecreate = time();
            $this->dateupdate = time();
            $this->hits = 0;
        } else {
            $this->dateupdate = time();
        }

        if (empty($this->slug)) {
            $this->slug = Inflector::slug($this->title);
        }

        return true;
    }

    /**
     * @return \Yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(\demi\comments\common\models\Comment::class, ['material_id' => 'id'])
                    ->andOnCondition(['material_type' => 1])
                    ->orderBy(['created_at' => SORT_ASC]);
    }

    /**
     * @inheritdoc
     *
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
                    ->select(['id', 'name', 'slug'])
                    ->viaTable(PostTag::tableName(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])->andOnCondition(['material_id' => $this->type_id]);
    }

    /**
     * @return bool
     */
    public function commentsAllowed(): bool
    {
        return $this->allow_comments;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        // no tags selected, remove current tags

        if (($this->form_tags === '') && !$insert) {
            PostTag::deleteAll(['post_id' => $this->id]);
        }

        // tags selected, save tags

        if (is_array($this->form_tags)) {

            if (!$insert) {
                // Remove current tags
                PostTag::deleteAll(['post_id' => $this->id]);
            }

            if (count($this->form_tags)) {

                // form tags array
                $tag_ids = [];

                foreach ($this->form_tags as $tagName) {
                    $tag_ids[] = Tag::getIdByName($tagName);
                }

                $tag_ids = array_unique($tag_ids);

                if (($i = array_search(null, $tag_ids)) !== false) {
                    unset($tag_ids[$i]);
                }

                if (count($tag_ids)) {
                    // Insert new relations data
                    $data = [];

                    foreach ($tag_ids as $tag_id) {
                        $data[] = [$this->id, $tag_id];
                    }

                    Yii::$app->db->createCommand()->batchInsert(
                        PostTag::tableName(),
                        ['post_id', 'tag_id'],
                        $data
                    )->execute();
                }

            }

        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        return true;
    }
}
