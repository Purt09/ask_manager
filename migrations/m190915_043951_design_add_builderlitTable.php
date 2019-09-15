<?php

use yii\db\Migration;

/**
 * Class m190915_043951_design_add_builderlitTable
 */
class m190915_043951_design_add_builderlitTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%builder_list_table}}', 'design', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190915_043951_design_add_builderlitTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190915_043951_design_add_builderlitTable cannot be reverted.\n";

        return false;
    }
    */
}
