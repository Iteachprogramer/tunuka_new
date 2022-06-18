<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_order_number_to_outcome_group}}`.
 */
class m220618_033127_create_add_order_number_to_outcome_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome_group}}','order_number',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%outcome_group}}','order_number');
    }
}
