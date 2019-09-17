<?php

use yii\db\Migration;

/**
 * Class m190915_181834_add_program_id_to_builder_page
 */
class m190915_181834_add_program_id_to_builder_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%builder_page}}', 'program_id', $this->integer()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190915_181834_add_program_id_to_builder_page cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190915_181834_add_program_id_to_builder_page cannot be reverted.\n";

        return false;
    }
    */
}
