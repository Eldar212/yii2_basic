<?php


namespace app\modules\api\v1\book\services;


use app\exceptions\BadRequestException;
use app\modules\api\v1\book\forms\BookCreateForm;
use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\book\models\RelationBookAuthor;
use app\modules\api\v1\user\models\User;
use Throwable;
use Yii;
use yii\db\StaleObjectException;

class BookService
{
    /**
     * @throws Throwable
     * @throws BadRequestException
     */
    public function create(User $user, array $request): Book
    {
        $form = new BookCreateForm($request);

        if (!$form->validate()) {
            throw new BadRequestException($form->getErrors(), 'Форма заполнена неверно');
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $book = new Book([
                'user_id' => $user->id,
                'name' => $form->name,
                'price' => $form->price,
                'description' => $form->description,
            ]);

            if (!$book->validate() || !$book->save()) {
                throw new BadRequestException($book->getErrors(), 'Не удалось создать книгу');
            }

            foreach ($form->author_ids as $authorId) {
                $relation = new RelationBookAuthor([
                    'book_id' => $book->id,
                    'author_id' => $authorId,
                ]);

                if (!$relation->validate() || !$relation->save()) {
                    throw new BadRequestException($relation->getErrors(), 'Не удалось создать книгу');
                }
            }

            $transaction->commit();

            return $book;

        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function update(User $user, int $id, array $request)
    {
        $book = Book::find()->where(['id' => $id])->one();

        $book->setAttributes($request);

        if (!$book->save())
        {
            throw new BadRequestException($book->getErrors(), 'Не удалось обновить информацию о книге');
        }

        $book->refresh();

        return $book;
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function delete(User $user, $id): string
    {
        $book = Book::find()->where(['id' => $id])->one();

        if (is_null($book))
        {
            throw new BadRequestException([], 'Не удалось найти книгу');
        }

        $book->delete();

        return "Товар с ib - {$id} успешно удален.";
    }

    public function getById(int $id)
    {
        $t =1;
        return Book::find()->where(['id' => $id])->one();
    }

    public function getList(): array
    {
        return Book::find()->all();
    }
}