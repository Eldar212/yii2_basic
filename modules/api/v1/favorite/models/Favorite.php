<?php

namespace app\modules\api\v1\favorite\models;

use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\user\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Favorite extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'favorites';
    }

    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    public function rules(): array
    {
        return [
            [['user_id', 'book_id'], 'required'],
            [['user_id', 'book_id', 'created_at', 'updated_at'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'book_id'
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
}