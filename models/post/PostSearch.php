<?php

namespace app\models\post;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\enums\PostStatus;
use app\enums\YesNo;

/**
 * PostSearch represents the model behind the search form about `app\models\post\Post`.
 */
class PostSearch extends Post
{
    /** @var int */
    public const FILTER_BY_HITS = 1;

    /** @var int */
    public const FILTER_BY_COMMENTS = 2;

    /** @var int */
    public $tagId;

    /** @var int */
    public $categoryId;

    /** @var int */
    public $sortBy;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'datecreate', 'dateupdate', 'category_id', 'user_id', 'hits', 'allow_comments', 'type_id'], 'integer'],
            [['title', 'content', 'tags', 'meta_description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => \Yii::$app->params['post']['pageSize'],
                ],
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type_id' => $this->type_id,
            'status_id' => PostStatus::STATUS_PUBLIC,
            'show_post_details' => YesNo::YES,
        ]);
        
        $query->andFilterWhere(['like', 'title', $this->title]);

        // Filter by tag id

        if (!$this->tagId) {
            $query->withCommentsCount()->all();
            $query->with(['tags']);
        } else {
            $query->joinWith(['tags']);
            $query->andWhere(['post_tags.tag_id' => $this->tagId]);
        }

        // Filter by category

        if ($this->categoryId) {
            $query->andWhere(['category_id' => $this->categoryId]);
        }

        if ($this->sortBy === self::FILTER_BY_HITS) {
            $query->orderBy('hits DESC');
        } elseif ($this->sortBy === self::FILTER_BY_COMMENTS) {
            $query->orderBy('commentsCount DESC');
        } else {
            $query->orderBy('datecreate DESC');
        }

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function adminSearch($params)
    {
        $query = Post::find()->orderBy('datecreate DESC');

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type_id'     => $this->type_id,
            'id'          => $this->id,
            'status_id'   => $this->status_id,
            'user_id'     => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->withCommentsCount()->all();

        return $dataProvider;
    }
}
