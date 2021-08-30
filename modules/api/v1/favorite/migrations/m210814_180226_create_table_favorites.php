<?php

use yii\db\Migration;

class m210814_180226_create_table_favorites extends Migration
{
    /**
     * @var string
     */
    protected $tableName = 'favorites';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id избранного товара'),
            'book_id' => $this->integer()->notNull()->comment('id книги'),
            'user_id' => $this->integer()->notNull()->comment('id пользователя'),
            'created_at' => $this->bigInteger()->comment('дата создания'),
            'updated_at' => $this->bigInteger()->comment('дата изменения'),
        ]);

        $this->createIndex("idx-{$this->tableName}-book_id", $this->tableName, 'book_id');
        $this->createIndex("idx-{$this->tableName}-user_id", $this->tableName, 'user_id');
        $this->createIndex("idx-{$this->tableName}-created_at", $this->tableName, 'created_at');
        $this->createIndex("idx-{$this->tableName}-updated_at", $this->tableName, 'updated_at');

        $this->addForeignKey(
            "FGK-{$this->tableName}-book_id-book-id",
            $this->tableName,
            'book_id',
            'book',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            "FGK-{$this->tableName}-user_id-user-id",
            $this->tableName,
            'user_id',
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
        $this->dropForeignKey("FGK-{$this->tableName}-user_id-user-id", $this->tableName);
        $this->dropForeignKey("FGK-{$this->tableName}-book_id-book-id", $this->tableName);

        $this->dropIndex("idx-{$this->tableName}-book_id", $this->tableName);
        $this->dropIndex("idx-{$this->tableName}-user_id", $this->tableName);
        $this->dropIndex("idx-{$this->tableName}-created_at", $this->tableName);
        $this->dropIndex("idx-{$this->tableName}-updated_at", $this->tableName);

        $this->dropTable($this->tableName);
    }
}
