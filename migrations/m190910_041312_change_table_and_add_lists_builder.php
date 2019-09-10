<?php

use yii\db\Migration;

/**
 * Class m190910_041312_change_table_and_add_lists_builder
 */
class m190910_041312_change_table_and_add_lists_builder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%builder_blocks}}', 'position', $this->integer());

        $this->addColumn('{{%builder_blocks}}', 'isHide', $this->smallInteger()->defaultValue(0));
        $this->addColumn('{{%builder_blocks}}', 'isDesktop', $this->smallInteger()->defaultValue(1));
        $this->addColumn('{{%builder_blocks}}', 'isTablet', $this->smallInteger()->defaultValue(1));
        $this->addColumn('{{%builder_blocks}}', 'isMobile', $this->smallInteger()->defaultValue(1));

        $this->dropColumn('{{%builder_blocks}}', 'style_media');

        $this->addColumn('{{%builder_commands}}', 'design', $this->smallInteger()->defaultValue(0));
        $this->addColumn('{{%builder_commands}}', 'col-sm', $this->smallInteger()->defaultValue(0));
        $this->addColumn('{{%builder_commands}}', 'peoples', $this->integer()->defaultValue(NULL));

        $this->dropColumn('{{%builder_command_people}}', 'design');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190910_041312_change_table_and_add_lists_builder cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190910_041312_change_table_and_add_lists_builder cannot be reverted.\n";

        return false;
    }
    */
}
