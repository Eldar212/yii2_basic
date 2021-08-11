<?php

use yii\db\Migration;

/**
 * Class m210727_080544_create_table_product
 */
class m210727_080544_create_table_book extends Migration
{

    protected $tableName = 'book';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName,[
            'id' => $this->primaryKey()->comment('id'),
            'user_id' => $this->integer()->notNull()->comment('Добовил в систему') ,
            'name' => $this->string()->notNull()->comment('Название книги'),
            'price' => $this->decimal(13, 2)->defaultValue(0)->comment('Стоимость книги'),
            'description' => $this->text()->comment('Стоимость книги'),
            'created_at' => $this->bigInteger()->comment('дата создания'),
            'updated_at' => $this->bigInteger()->comment('дата изменения'),
        ]);

        $this->createIndex("idx-{$this->tableName}-user_id", $this->tableName, 'user_id');
        $this->createIndex("idx-{$this->tableName}-name", $this->tableName, 'name');
        $this->createIndex("idx-{$this->tableName}-price", $this->tableName, 'price');
        $this->createIndex("idx-{$this->tableName}-created_at", $this->tableName, 'created_at');
        $this->createIndex("idx-{$this->tableName}-updated_at", $this->tableName, 'updated_at');

        $this->addForeignKey(
            "FGK-{$this->tableName}-user_id-user-id",
            $this->tableName,
            'user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("FGK-{$this->tableName}-user_id-user-id", $this->tableName );
        $this->dropTable($this->tableName);
    }
}
