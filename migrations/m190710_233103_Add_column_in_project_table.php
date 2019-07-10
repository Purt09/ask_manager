<?php

use yii\db\Migration;

/**
 * Class m190710_233103_Add_column_in_project_table
 */
class m190710_233103_Add_column_in_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%project}}', 'creator_id', $this->integer()->notNull());


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%project}}', 'creator_id');


        echo "m190710_233103_Add_column_in_project_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190710_233103_Add_column_in_project_table cannot be reverted.\n";

        return false;
    }
    */
}
