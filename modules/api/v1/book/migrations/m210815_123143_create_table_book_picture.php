<?php

use yii\db\Migration;

/**
 * Class m210815_123143_create_table_book_picture
 */
class m210815_123143_create_table_book_picture extends Migration
{
    protected $tableName = 'book_picture';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id'),
            'book_id' => $this->integer()->notNull()->comment('id книги'),
            'path' => $this->string()->notNull()->comment('путь к избражению'),
            'is_main' => $this->smallInteger()->notNull()->defaultValue(0)->comment('превью?'),
            'created_at' => $this->bigInteger()->comment('дата создания'),
            'updated_at' => $this->bigInteger()->comment('дата изменения'),
        ]);

        $this->createIndex("IDX-{$this->tableName}-book_id", $this->tableName, 'book_id');
        $this->createIndex("IDX-{$this->tableName}-path", $this->tableName, 'path');
        $this->createIndex("IDX-{$this->tableName}-is_main", $this->tableName, 'is_main');
        $this->createIndex("IDX-{$this->tableName}-created_at", $this->tableName, 'created_at');
        $this->createIndex("IDX-{$this->tableName}-updated_at", $this->tableName, 'updated_at');

        $this->addForeignKey(
            "FGK-{$this->tableName}-book_id-book-id",
            $this->tableName,
            'book_id',
            'book',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("FGK-{$this->tableName}-book_id-book-id", $this->tableName);
        $this->dropTable($this->tableName);
    }
}
