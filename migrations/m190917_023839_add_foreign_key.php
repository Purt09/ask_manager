<?php

use yii\db\Migration;

/**
 * Class m190917_023839_add_foreign_key
 */
class m190917_023839_add_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-blocks-list-item', '{{%builder_list_item}}','list_id','{{%builder_list}}', 'id',  'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190917_023839_add_foreign_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190917_023839_add_foreign_key cannot be reverted.\n";

        return false;
    }
    */
}
