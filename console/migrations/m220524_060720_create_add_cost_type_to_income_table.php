<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_cost_type_to_income}}`.
 */
class m220524_060720_create_add_cost_type_to_income_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%income}}', 'cost_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%income}}', 'cost_type');
    }
}
