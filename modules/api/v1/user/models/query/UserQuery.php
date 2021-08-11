<?php


namespace app\modules\api\v1\user\models\query;

use app\modules\api\v1\user\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\modules\api\v1\user\models\User]].
 *
 * @see \app\modules\api\v1\user\models\User
 */
class UserQuery extends ActiveQuery
{
    public function byActive()
    {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    public function byId($id): UserQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function byEmail($email): UserQuery
    {
        return $this->andWhere(['email' => $email]);
    }
}
