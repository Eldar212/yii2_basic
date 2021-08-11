<?php

use yii\db\Migration;

/**
 * Class m210730_083335_create_table_book_author
 */
class m210730_083335_create_table_book_author extends Migration
{

    protected $tableName = 'book_author';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('id автора'),
            'first_name' => $this->string()->notNull()->comment('Имя'),
            'middle_name' => $this->string()->notNull()->comment('Фамилия'),
            'last_name' => $this->string()->comment('Отчество'),
            'created_at' => $this->bigInteger()->comment('дата создания'),
            'updated_at' => $this->bigInteger()->comment('дата изменения'),
        ]);

        $this->createIndex("IDX-{$this->tableName}-first_name", $this->tableName, 'first_name' );
        $this->createIndex("IDX-{$this->tableName}-middle_name", $this->tableName, 'middle_name' );
        $this->createIndex("IDX-{$this->tableName}-last_name", $this->tableName, 'last_name' );
        $this->createIndex("IDX-{$this->tableName}-created_at", $this->tableName, 'created_at' );
        $this->createIndex("IDX-{$this->tableName}-updated_at", $this->tableName, 'updated_at' );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
