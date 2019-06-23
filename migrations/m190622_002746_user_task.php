<?php

use yii\db\Migration;

/**
 * Class m190622_002746_user_task
 */
class m190622_002746_user_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_task}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'chain_to_task',
            '{{%user_task}}',
            'task_id',
            '{{%task}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'chain_to_user',
            '{{%user_task}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_friend}}');

        $this->dropForeignKey('chain_to_task');
        $this->dropForeignKey('chain_to_user');

        echo "m190622_002746_user_task cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190622_002746_user_task cannot be reverted.\n";

        return false;
    }
    */
}
