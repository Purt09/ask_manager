<?php

use yii\db\Migration;

/**
 * Class m190913_025547_change_blocks
 */
class m190913_025547_change_blocks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%builder_blocks}}', 'css_background', $this->string()->defaultValue('FFFFFF')->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190913_025547_change_blocks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190913_025547_change_blocks cannot be reverted.\n";

        return false;
    }
    */
}
