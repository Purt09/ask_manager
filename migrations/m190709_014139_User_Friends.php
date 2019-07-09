<?php

use yii\db\Migration;

/**
 * Class m190709_014139_User_Friends
 */
class m190709_014139_User_Friends extends Migration
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

        $this->createTable('{{%user_friends}}', [
            'id' => $this->primaryKey(),
            'user_id_1' => $this->integer()->notNull(),
            'user_id_2' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'chain_to_user_1',
            '{{%user_friends}}',
            'user_id_1',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'chain_to_user_2',
            '{{%user_friends}}',
            'user_id_2',
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
        echo "m190709_014139_User_Friends cannot be reverted.\n";

        $this->dropTable('{{%user_friends}}');

        $this->dropForeignKey('chain_to_user_1');
        $this->dropForeignKey('chain_to_user_2');


        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190709_014139_User_Friends cannot be reverted.\n";

        return false;
    }
    */
}
