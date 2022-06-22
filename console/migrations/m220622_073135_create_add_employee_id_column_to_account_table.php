<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_employee_id_column_to_account}}`.
 */
class m220622_073135_create_add_employee_id_column_to_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%account}}','employee_id',$this->integer());
        $this->addForeignKey('account_employee_id','{{%account}}','employee_id','{{%employees}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('account_employee_id','{{%account}}');
        $this->dropColumn('{{%account}}','employee_id');
    }
}
