<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%report}}`.
 */
class m220721_134911_create_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer()->notNull(),
            'date' => $this->integer()->notNull(),
            'work_time' => $this->float(),
            'start_day' => $this->time(),
            'end_day' => $this->time(),
        ]);
        $this->addForeignKey('fk_report_employee_id', '{{%report}}', 'employee_id', '{{%employees}}', 'id', 'CASCADE');
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_report_employee_id', '{{%report}}');
        $this->dropTable('{{%report}}');
    }
}
