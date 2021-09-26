<?php

namespace app\modules\api\v1\comments\models\query;

use app\modules\api\v1\comments\models\Comments;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\modules\api\v1\comments\models\Comments]].
 *
 * @see \app\modules\api\v1\comments\models\Comments
 */
class CommentsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Comments[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Comments|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
