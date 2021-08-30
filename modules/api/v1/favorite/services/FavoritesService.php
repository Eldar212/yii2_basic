<?php

namespace app\modules\api\v1\favorite\services;

use app\exceptions\BadRequestException;
use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\favorite\models\Favorite;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;

class FavoritesService
{
    /**
     * @throws Exception
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function add($id, $user)
    {
        $findBook = Book::find()->where(['id' => $id])->one();

        if (is_null($findBook)){
            throw new BadRequestException([], 'Не удалось найти книгу');
        }

        $isExistFavorite = Favorite::find()->where(['user_id' => $user->id, 'book_id' => $id])->one();

        if (is_null($isExistFavorite)) {
            $favoriteBook = new Favorite([
                'user_id' => $user->id,
                'book_id' => $id
            ]);

            if (!$favoriteBook->validate() || !$favoriteBook->save()) {
                throw new BadRequestException($favoriteBook->getErrors(), 'Не удалось добавить книгу в избранное');
            }
        } else {
            $isExistFavorite->delete();
        }

      return true;
    }
}