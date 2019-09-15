<?php

use yii\db\Migration;

/**
 * Class m190915_065623_add_column_bulderAdvantages
 */
class m190915_065623_add_column_bulderAdvantages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%builder_list_table}}', 'desc1', $this->text());
        $this->addColumn('{{%builder_list_table}}', 'desc2', $this->text());
        $this->addColumn('{{%builder_list_table}}', 'desc3', $this->text());
        $this->addColumn('{{%builder_list_table}}', 'desc4', $this->text());
        $this->addColumn('{{%builder_list_table}}', 'desc5', $this->text());
        $this->addColumn('{{%builder_list_table}}', 'desc6', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190915_065623_add_column_bulderAdvantages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190915_065623_add_column_bulderAdvantages cannot be reverted.\n";

        return false;
    }
    */
}
