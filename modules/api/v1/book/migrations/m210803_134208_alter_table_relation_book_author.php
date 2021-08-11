<?php

use yii\db\Migration;

/**
 * Class m210803_134208_alter_table_relation_book_author
 */
class m210803_134208_alter_table_relation_book_author extends Migration
{
    protected $tableName = 'relation_book_author';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex("idx-{$this->tableName}-book_id-author_id", $this->tableName, ['book_id', 'author_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex("idx-{$this->tableName}-book_id-author_id", $this->tableName);
    }
}
