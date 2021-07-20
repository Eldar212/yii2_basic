<?php

use yii\db\Migration;

/**
 * Class m210716_042306_test_migrate
 */
class m210716_042306_test_migrate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210716_042306_test_migrate cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210716_042306_test_migrate cannot be reverted.\n";

        return false;
    }
    */
}
