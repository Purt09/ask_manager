<?php

use yii\db\Migration;

/**
 * Class m190719_074918_phone_user_table
 */
class m190719_074918_phone_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'phone', $this->string(18));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190719_074918_phone_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190719_074918_phone_user_table cannot be reverted.\n";

        return false;
    }
    */
}
