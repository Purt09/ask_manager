<?php

use yii\db\Migration;

/**
 * Class m190626_014719_Add_column_in_uset_table
 */
class m190626_014719_Add_column_in_uset_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'first_name', $this->string(64) );
        $this->addColumn('{{%user}}', 'last_name', $this->string(64) );
        $this->addColumn('{{%user}}', 'photo', $this->string(255) );
        $this->addColumn('{{%user}}', 'photo_medium', $this->string(255) );
        $this->addColumn('{{%user}}', 'photo_big', $this->string(255) );
        $this->addColumn('{{%user}}', 'phone', $this->integer(11) );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'first_name');
        $this->dropColumn('{{%user}}', 'last_name');
        $this->dropColumn('{{%user}}', 'photo');
        $this->dropColumn('{{%user}}', 'photo_medium');
        $this->dropColumn('{{%user}}', 'photo_big');
        $this->dropColumn('{{%user}}', 'phone');
        echo "m190626_014719_Add_column_in_uset_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190626_014719_Add_column_in_uset_table cannot be reverted.\n";

        return false;
    }
    */
}
