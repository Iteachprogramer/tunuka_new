<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_type_id_column_to_outcome}}`.
 */
class m220601_122110_create_add_type_id_column_to_outcome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome}}', 'type_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%outcome}}', 'type_id');
    }
}
