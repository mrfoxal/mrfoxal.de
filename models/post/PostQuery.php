<?php

namespace app\models\post;

use demi\comments\common\models\Comment;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * This is the ActiveQuery class for [[Post]].
 *
 * @see Post
 */
class PostQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Select comments count
     *
     * @return static
     */
    public function withCommentsCount()
    {
        if ($this->select === null) {
            $this->select = ['*'];
        }

        $countQuery = (new Query())->select('COUNT(*)')->from(Comment::tableName())
                                   ->where(
                                       'material_type=:typePost AND material_id=post.id',
                                       [
                                       ':typePost' => 1,
                                       ]
                                   );

        return $this->addSelect(['commentsCount' => $countQuery]);
    }
}
