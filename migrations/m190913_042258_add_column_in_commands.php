<?php

use yii\db\Migration;

/**
 * Class m190913_042258_add_column_in_commands
 */
class m190913_042258_add_column_in_commands extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%builder_commands}}', 'gor_col_image', $this->smallInteger()->defaultValue(4)->notNull());
        $this->addColumn('{{%builder_commands}}', 'gor_col_content', $this->smallInteger()->defaultValue(8)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190913_042258_add_column_in_commands cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190913_042258_add_column_in_commands cannot be reverted.\n";

        return false;
    }
    */
}
