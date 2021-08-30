<?php

namespace app\modules\api\v1\book\services;

use app\exceptions\BadRequestException;
use app\modules\api\v1\book\forms\AttachEntityForm;
use app\modules\api\v1\book\forms\AuthorAddForm;
use app\modules\api\v1\book\models\BookAuthor;
use app\modules\api\v1\book\models\RelationBookAuthor;
use phpDocumentor\Reflection\Types\Boolean;
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
    public function delete($id): bool
    {
        $author = BookAuthor::find()->where(['id' => $id])->one();

        if (is_null($author)) {
            throw new BadRequestException([], 'Не удалось найти книгу');
        }

        $author->delete();

        return true;
    }

    /**
     * @throws BadRequestException
     */
    public function pinBook($request)
    {
        $form = new AttachEntityForm($request);

        if (!$form->validate()) {
            throw new BadRequestException([], 'Валидация не пройдена');
        }

        $isExistRelation = RelationBookAuthor::find()
            ->where(['author_id' => $form->author_id, 'book_id' => $form->book_id])
            ->exists();

        if ($isExistRelation) {
            throw new BadRequestException([], 'Данная свящь уже существует');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $relation = new RelationBookAuthor([
                'book_id' => $form->book_id,
                'author_id' => $form->author_id
            ]);

            if (!$relation->validate() || !$relation->save()) {
                throw new BadRequestException($relation->getErrors(), 'Не удалось прикрепить книгу');
            }

            $transaction->commit();

            return $relation;

        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}