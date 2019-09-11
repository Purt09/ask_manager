<?php

use yii\db\Migration;

/**
 * Class m190911_022342_change_column_commands
 */
class m190911_022342_change_column_commands extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%builder_commands}}', 'col-sm');
        $this->addColumn('{{%builder_commands}}', 'col', $this->smallInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190911_022342_change_column_commands cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190911_022342_change_column_commands cannot be reverted.\n";

        return false;
    }
    */
}
