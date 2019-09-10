<?php

use yii\db\Migration;

/**
 * Class m190910_014232_add_column_in_blocks_and_create_comands_table
 */
class m190910_014232_add_column_in_blocks_and_create_comands_table extends Migration
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
        echo "m190910_014232_add_column_in_blocks_and_create_comands_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190910_014232_add_column_in_blocks_and_create_comands_table cannot be reverted.\n";

        return false;
    }
    */
}
