<?php

use yii\db\Migration;

/**
 * Class m190417_014806_change_update_at_column_to_task_table
 */
class m190417_014806_change_update_at_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('keys_task', 'updated_at', $this->dateTime());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('keys_task', 'updated_at', $this->integer());
        echo "m190417_014806_change_update_at_column_to_task_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190417_014806_change_update_at_column_to_task_table cannot be reverted.\n";

        return false;
    }
    */
}
