<?php

use yii\db\Migration;

/**
 * Class m190704_144746_user_project_connections_many_to_many
 */
class m190704_144746_user_project_connections_many_to_many extends Migration
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

        $this->createTable('{{%user_project}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'chain_to_project',
            '{{%user_project}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'project_to_user',
            '{{%user_project}}',
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
        $this->dropTable('{{%user_project}}');

        $this->dropForeignKey('chain_to_project');
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
