<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%report}}`.
 */
class m220726_043354_add_employe_working_time_column_to_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%report}}', 'employe_working_time', $this->time()->defaultValue(null));
        $this->addColumn('{{%report}}', 'employe_working_time_end', $this->time()->defaultValue(null));

    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%report}}', 'employe_working_time');
        $this->dropColumn('{{%report}}', 'employe_working_time_end');
    }
}
