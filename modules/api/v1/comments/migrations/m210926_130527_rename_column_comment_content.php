<?php

use yii\db\Migration;

/**
 * Class m210926_130527_rename_column_comment_content
 */
class m210926_130527_rename_column_comment_content extends Migration
{
    protected string $tableName = 'comments';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn($this->tableName, 'comment-content', 'comment_content');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->renameColumn($this->tableName, 'comment_content', 'comment-content');
    }
}
