<?php

use yii\db\Migration;

/**
 * Class m210730_084646_create_table_relation_book_author
 */
class m210730_084646_create_table_relation_book_author extends Migration
{

    protected $tableName = 'relation_book_author';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName,[
            'id' => $this->primaryKey()->comment('id связи'),
            'book_id' => $this->integer()->notNull()->comment('id книги'),
            'author_id' => $this->integer()->comment('id автора'),
            'created_at' => $this->bigInteger()->comment('дата создания'),
            'updated_at' => $this->bigInteger()->comment('дата изменения'),
        ]);

        $this->createIndex("idx-{$this->tableName}-book_id", $this->tableName, 'book_id');
        $this->createIndex("idx-{$this->tableName}-author_id", $this->tableName, 'author_id');
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
            "FGK-{$this->tableName}-author_id-book_author-id",
            $this->tableName,
            'author_id',
            'book_author',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropForeignKey("FGK-{$this->tableName}-author_id-book_author-id", $this->tableName);
      $this->dropForeignKey("FGK-{$this->tableName}-book_id-book-id", $this->tableName);

      $this->dropTable($this->tableName);
    }
}
