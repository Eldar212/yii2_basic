<?php

    use yii\db\Migration;

    /**
     * Class m210716_073330_create_table_user
     */
    class m210716_073330_create_table_user extends Migration
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


            $this->createIndex("idx-{$this->tableName}-email", $this->tableName, "email", true);
            $this->createIndex("idx-{$this->tableName}-password_hash", $this->tableName, "password_hash");
            $this->createIndex("idx-{$this->tableName}-password_reset_token", $this->tableName, "password_reset_token");
            $this->createIndex("idx-{$this->tableName}-status", $this->tableName, "status");
            $this->createIndex("idx-{$this->tableName}-created_at", $this->tableName, "created_at");
            $this->createIndex("idx-{$this->tableName}-updated_at", $this->tableName, "updated_at");
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropTable($this->tableName);
        }
    }
