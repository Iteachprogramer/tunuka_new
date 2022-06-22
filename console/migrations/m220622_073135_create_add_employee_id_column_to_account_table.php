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
        $this->createTable('{{%add_employee_id_column_to_account}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%add_employee_id_column_to_account}}');
    }
}
