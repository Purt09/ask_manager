<?php

use yii\db\Migration;

/**
 * Class m190817_073909_chat_tables_create
 */
class m190817_073909_chat_tables_create extends Migration
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

        $this->createTable('{{%chat_chat}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%chat_users}}', [
            'chat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%chat_message}}', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%chat_message_status}}', [
            'message_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'is_read' => $this->smallInteger()->defaultValue(0),
        ], $tableOptions);

        $this->addColumn('{{%project}}', 'chat_id', $this->integer()->notNull());

        $this->addColumn('{{%user_friends}}', 'chat_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%chat_chat}}');
        $this->dropTable('{{%chat_users}}');
        $this->dropTable('{{%chat_message}}');
        $this->dropColumn('{{%project}}', 'chat_id');
        $this->dropColumn('{{%user_friends}}', 'chat_id');

        echo "m190817_073909_chat_tables_create cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190817_073909_chat_tables_create cannot be reverted.\n";

        return false;
    }
    */
}
