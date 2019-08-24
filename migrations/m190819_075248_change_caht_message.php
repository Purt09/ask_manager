<?php

use yii\db\Migration;

/**
 * Class m190819_075248_change_caht_message
 */
class m190819_075248_change_caht_message extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%chat_message}}', 'user_id', $this->integer()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190819_075248_change_caht_message cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190819_075248_change_caht_message cannot be reverted.\n";

        return false;
    }
    */
}
