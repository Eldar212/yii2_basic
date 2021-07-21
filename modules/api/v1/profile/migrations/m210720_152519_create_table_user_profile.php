<?php

use yii\db\Migration;

/**
 * Class m210720_152519_create_table_user_profile
 */
class m210720_152519_create_table_user_profile extends Migration
{
    protected $tableName = 'user_profile';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('ID пользователя'),
            'name' => $this->string()->notNull()->comment('Имя пользователя'),
            'middle_name' => $this->string()->notNull()->comment('Фамилия пользователя'),
            'last_name' => $this->string()->notNull()->comment('Отчество пользователя'),
            'phone' => $this->string()->comment('Номер телефона'),
            'created_at' => $this->bigInteger()->comment('дата создания'),
            'updated_at' => $this->bigInteger()->comment('дата изменения'),
        ]);

        $this->createIndex("idx-{$this->tableName}-user_id", $this->tableName, 'user_id', true);
        $this->createIndex("idx-{$this->tableName}-name", $this->tableName, 'name');
        $this->createIndex("idx-{$this->tableName}-middle_name", $this->tableName, 'middle_name');
        $this->createIndex("idx-{$this->tableName}-last_name", $this->tableName, 'last_name');
        $this->createIndex("idx-{$this->tableName}-phone", $this->tableName, 'phone', true);
        $this->createIndex("idx-{$this->tableName}-created_at", $this->tableName, 'created_at');
        $this->createIndex("idx-{$this->tableName}-updated_at", $this->tableName, 'updated_at');

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
        $this->dropTable($this->tableName);
    }
}
