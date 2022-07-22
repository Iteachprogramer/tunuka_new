<?php

use yii\db\Migration;

/**
 * Class m220722_070025_add_start_day_and_end_day_to_employee_table
 */
class m220722_070025_add_start_day_and_end_day_to_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%employees}}', 'start_day', $this->time()->notNull());
        $this->addColumn('{{%employees}}', 'end_day', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%employees}}', 'start_day');
        $this->dropColumn('{{%employees}}', 'end_day');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220722_070025_add_start_day_and_end_day_to_employee_table cannot be reverted.\n";

        return false;
    }
    */
}
