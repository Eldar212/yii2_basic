<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile}}`.
 */
class m210716_081705_create_profile_table extends Migration
{
    protected $tableName = 'user_profile';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('ID пользователя'),
            'name' => $this->string()->notNull()->comment('Имя пользователя'),
            'module_name' => $this->string()->notNull()->comment('Фамилия пользователя'),
            'last_name' => $this->string()->notNull()->comment('Отчество пользователя'),
            'phone' => $this->string()->comment('Номер телефона'),
            'created_at' => $this->bigInteger()->comment('Дата создания'),
            'updated_at' => $this->bigInteger()->comment('Дата изменения'),
        ]);

        $this->createIndex("idx-{$this->tableName}-user_id", $this->tableName, "password_reset_token");
        $this->createIndex("idx-{$this->tableName}-name", $this->tableName, "password_reset_token");
        $this->createIndex("idx-{$this->tableName}-module_name", $this->tableName, "password_reset_token");
        $this->createIndex("idx-{$this->tableName}-last_name", $this->tableName, "password_reset_token");
        $this->createIndex("idx-{$this->tableName}-phone", $this->tableName, "password_reset_token");
        $this->createIndex("idx-{$this->tableName}-created_at", $this->tableName, "password_reset_token");
        $this->createIndex("idx-{$this->tableName}-updated_at", $this->tableName, "password_reset_token");

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
