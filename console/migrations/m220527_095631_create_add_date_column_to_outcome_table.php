<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_date_column_to_outcome}}`.
 */
class m220527_095631_create_add_date_column_to_outcome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome}}', 'date', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%outcome}}', 'date');
    }
}
