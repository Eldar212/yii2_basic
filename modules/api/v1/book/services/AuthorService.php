<?php

namespace app\modules\api\v1\book\services;

use app\exceptions\BadRequestException;
use app\modules\api\v1\book\forms\AuthorAddForm;
use app\modules\api\v1\book\models\BookAuthor;
use app\modules\api\v1\book\models\RelationBookAuthor;
use app\modules\api\v1\user\models\User;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;

class AuthorService
{
    /**
     * @throws Throwable
     * @throws Exception
     * @throws BadRequestException
     */
    public function create($request): BookAuthor
    {
        $form = new AuthorAddForm($request);

        if (!$form->validate()) {
            throw new BadRequestException($form->getErrors(), 'Форма заполнена неверно');
        }

            $transaction = Yii::$app->db->beginTransaction();

        try {
            $author = new BookAuthor([
                'first_name' => $form->first_name,
                'middle_name' => $form->middle_name,
                'last_name' => $form->last_name,
            ]);

            if (!$author->validate() || !$author->save()) {
                throw new BadRequestException($author->getErrors(), 'Не удалось добавить автора книги');
            }

            foreach ($form->book_ids as $bookId) {

                $relation = new RelationBookAuthor([
                    'book_id' => $bookId,
                    'author_id' => $author->id,
                ]);

                if (!$relation->validate() || !$relation->save()) {
                    throw new BadRequestException($relation->getErrors(), 'Не удалось создать книгу');
                }
            }

            $transaction->commit();

            return $author;
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @throws BadRequestException
     */
    public function update($id, $request)
    {
        $author = BookAuthor::find()->where(['id' => $id])->one();

        if (is_null($author)) {
            throw new BadRequestException([], 'Не удалось найти автора');
        }

        $author->setAttributes($request);

        if (!$author->save()) {
            throw new BadRequestException([], 'Не удалось обновить автора');
        }

        $author->refresh();

        return $author;
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     * @throws BadRequestException
     */
    public function delete($id): string
    {
        $author = BookAuthor::find()->where(['id' => $id])->one();

        if (is_null($author)) {
            throw new BadRequestException([], 'Не удалось найти книгу');
        }

        $author->delete();

        return "Товар с ib - {$id} успешно удален.";
    }

    public function pinBook($request)
    {
        return 'book';
    }
}