<?php

use yii\db\Migration;

/**
 * Class m190412_004042_update_task_table
 */
class m190412_004042_update_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('task', 'created_at', $this->timestamp()->notNull());
        $this->alterColumn('task', 'updated_at', $this->dateTime()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190412_004042_update_task_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190412_004042_update_task_table cannot be reverted.\n";

        return false;
    }
    */
}
