<?php

use yii\db\Migration;

/**
 * Class m210926_122841_create_table_comments
 */
class m210926_122841_create_table_comments extends Migration
{
    protected string $tableName = 'comments';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id комментария'),
            'book_id' => $this->integer()->notNull()->comment('id книги'),
            'comment_author_id' => $this->integer()->notNull()->comment('id автора комментария'),
            'comment-content' => $this->text()->notNull()->comment('текст комментария'),
            'comment_title' => $this->char(60)->comment('заголовок комментария'),
            'like_count' => $this->integer()->comment('количество лайков'),
            'dislike_count' => $this->integer()->comment('количество дизлайков'),
            'created_at' => $this->bigInteger()->comment('дата создания'),
            'updated_at' => $this->bigInteger()->comment('дата изменения'),
        ]);

        $this->createIndex("idx-{$this->tableName}-book_id", $this->tableName, 'book_id');
        $this->createIndex("idx-{$this->tableName}-comment_author_id", $this->tableName, 'comment_author_id');
        $this->createIndex("idx-{$this->tableName}-comment_title", $this->tableName, 'comment_title');
        $this->createIndex("idx-{$this->tableName}-like_count", $this->tableName, 'like_count');
        $this->createIndex("idx-{$this->tableName}-dislike_count", $this->tableName, 'dislike_count');
        $this->createIndex("idx-{$this->tableName}-created_at", $this->tableName, 'created_at');
        $this->createIndex("idx-{$this->tableName}-updated_at", $this->tableName, 'updated_at');

        $this->addForeignKey(
            "FGK-{$this->tableName}_book_id-book_id",
            $this->tableName,
            'book_id',
            'book',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            "FGK-{$this->tableName}-comment_author_id-user-id",
            $this->tableName,
            'comment_author_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("FGK-{$this->tableName}-comment_author_id-user-id", $this->tableName);
        $this->dropForeignKey("FGK-{$this->tableName}_book_id-book_id", $this->tableName);

        $this->dropTable($this->tableName);
    }
}
