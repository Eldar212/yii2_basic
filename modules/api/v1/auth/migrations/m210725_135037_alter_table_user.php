<?php

use yii\db\Migration;

/**
 * Class m210725_135037_alter_table_user
 */
class m210725_135037_alter_table_user extends Migration
{
    protected $tableName = 'user';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'access_token', $this->string()->after('status')->comment('Токен доступа'));
        $this->createIndex("idx-{$this->tableName}-access_token", $this->tableName, 'access_token', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex("idx-{$this->tableName}-access_token", $this->tableName);
        $this->dropColumn($this->tableName, 'access_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210725_135037_alter_table_user cannot be reverted.\n";

        return false;
    }
    */
}
