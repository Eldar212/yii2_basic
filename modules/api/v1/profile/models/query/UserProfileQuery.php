<?php

namespace app\modules\api\v1\profile\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\api\v1\profile\models\UserProfile]].
 *
 * @see \app\modules\api\v1\profile\models\UserProfile
 */
class UserProfileQuery extends \yii\db\ActiveQuery
{
    public function byUserId($userId)
    {
        return $this->andWhere(['user_id' => $userId]);
    }

    public function byPhone($phone): UserProfileQuery
    {
        return $this->andWhere(['phone' => $phone]);
    }
}