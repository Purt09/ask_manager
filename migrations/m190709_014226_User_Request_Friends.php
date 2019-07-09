<?php

use yii\db\Migration;

/**
 * Class m190709_014226_User_Request_Friends
 */
class m190709_014226_User_Request_Friends extends Migration
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

        $this->createTable('{{%user_request_for_friend}}', [
            'id' => $this->primaryKey(),
            'sender' => $this->integer()->notNull(),
            'taker' => $this->integer()->notNull(),
            'accept' => $this->smallInteger(8),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_request_for_friend}}');

        echo "m190709_014226_User_Request_Friends cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190709_014226_User_Request_Friends cannot be reverted.\n";

        return false;
    }
    */
}
