<?php

namespace app\modules\api\v1\book\services;

use app\exceptions\BadRequestException;
use app\modules\api\v1\book\forms\BookForm;
use app\modules\api\v1\book\models\Book;
use app\modules\api\v1\book\models\BookPicture;
use app\modules\api\v1\book\models\RelationBookAuthor;
use app\modules\api\v1\user\models\User;
use app\modules\core\helpers\FileHelper;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class BookService
{
    /**
     * @throws Throwable
     * @throws BadRequestException
     */
    public function create(User $user, array $request): Book
    {
        $form = new BookForm($request);
        $form->setScenario(BookForm::SCENARIO_CREATE);
        $form->preview = UploadedFile::getInstanceByName('preview');
        $form->pictures = UploadedFile::getInstancesByName('pictures');

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

            $pictures = $form->getBookPictures();

            foreach ($pictures as $picture) {
                $bookPicture = new BookPicture([
                    'book_id' => $book->id,
                    'path' => $picture['img'],
                    'is_main' => $picture['is_main'],
                ]);

                if (!$bookPicture->validate() || !$bookPicture->save()) {
                    throw new BadRequestException($bookPicture->getErrors(), 'Не удалось загрузить изображение.');
                }
            }

            $transaction->commit();

            return $book;

        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @throws Throwable
     * @throws BadRequestException
     * @throws StaleObjectException
     */
    public function update(int $id, array $request)
    {
        $book = Book::find()->where(['id' => $id])->one();

        if (is_null($book)) {
            throw new BadRequestException([], 'Книга не найдена');
        }

        $form = new BookForm($request);
        $form->preview = UploadedFile::getInstanceByName('preview');
        $form->pictures = UploadedFile::getInstancesByName('pictures');

        if (!$form->validate()) {
            throw new BadRequestException($form->getErrors(), 'Форма заполнена неверно');
        }

        $pictures = $form->getBookPictures();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($pictures as $picture) {
                if ($picture['is_main'] && !is_null($picture['img'])) {
                    $bookPicture = BookPicture::find()
                        ->where([
                            'book_id' => $book->id,
                            'is_main' => BookPicture::IS_MAIN
                        ])
                        ->one();

                    if (!is_null($bookPicture)) {
                        $bookPicture->delete();
                    }

                    $bookPicture = new BookPicture([
                        'book_id' => $book->id,
                        'path' => $picture['img'],
                        'is_main' => $picture['is_main'],
                    ]);

                    if (!$bookPicture->validate() || !$bookPicture->save()) {
                        throw new BadRequestException($bookPicture->getErrors(), 'Не удалось загрузить изображение.');
                    }
                }
                if (!$picture['is_main'] && !is_null($picture['img'])) {
                    $bookPicture = BookPicture::find()
                        ->where([
                            'book_id' => $book->id,
                            'is_main' => BookPicture::IS_NOT_MAIN
                        ])->all();

                    if (!is_null($bookPicture)) {
                        foreach ($bookPicture as $oldPicture)
                            $oldPicture->delete();
                    }
                }
            }

            foreach ($pictures as $picture) {
                if (!$picture['is_main'] && !is_null($picture['img'])) {
                    $bookPicture = new BookPicture([
                        'book_id' => $book->id,
                        'path' => $picture['img'],
                        'is_main' => $picture['is_main'],
                    ]);

                    if (!$bookPicture->validate() || !$bookPicture->save()) {
                        throw new BadRequestException($bookPicture->getErrors(), 'Не удалось загрузить изображение.');
                    }
                }
            }

            $request = [
                'name' => $request['name'] ?? $book->name,
                'price' => $request['price'] ?? $book->price,
                'description' => $request['description'] ?? $book->description
            ];
            $book->setAttributes($request);

            if (!$book->save()) {
                throw new BadRequestException($book->getErrors(), 'Не удалось обновить информацию о книге');
            }

            $transaction->commit();

            $book->refresh();

            return $book;

        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function delete(User $user, $id): string
    {
        $book = Book::find()->where(['id' => $id])->one();

        if (is_null($book)) {
            throw new BadRequestException([], 'Не удалось найти книгу');
        }

        $book->delete();

        return "Товар с ib - {$id} успешно удален.";
    }

    public function getById(int $id)
    {
        return Book::find()->where(['id' => $id])->one();
    }

    public function getList(): array
    {
        return Book::find()->all();
    }
}