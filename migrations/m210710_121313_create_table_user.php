<?php

use yii\db\Migration;

/**
 * Class m210710_121313_create_table_user
 */
class m210710_121313_create_table_user extends Migration
{

    protected $tableName = 'user';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable($this->tableName, [
        'id' => $this->primaryKey()->comment('id'),
        'email' => $this->string()->notNull()->unique(),
        'password_hash' => $this->string()->unique()->comment('хэш пароля'),
        'password_reset_token' => $this->string()->unique()->comment('кен на изменение пароля'),
        'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment('статус'),
        'created_at' => $this->bigInteger()->comment('дата создания'),
        'updated_at' => $this->bigInteger()->comment('дата изменения'),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210710_121313_create_table_user cannot be reverted.\n";

        return false;
    }

}
