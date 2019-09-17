<?php

use yii\db\Migration;

/**
 * Class m190917_021518_delete_foreign_key
 */
class m190917_021518_delete_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-blocks-block_html', '{{%builder_blocks}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190917_021518_delete_foreign_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190917_021518_delete_foreign_key cannot be reverted.\n";

        return false;
    }
    */
}
