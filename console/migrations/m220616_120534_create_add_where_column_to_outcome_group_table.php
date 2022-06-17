<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_where_column_to_outcome_group}}`.
 */
class m220616_120534_create_add_where_column_to_outcome_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%outcome_group}}', 'where', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%outcome_group}}', 'where');
    }
}
