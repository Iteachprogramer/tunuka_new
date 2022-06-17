<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_factory_expence_column_to_product_list}}`.
 */
class m220531_014957_create_add_factory_expence_column_to_product_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_list}}', 'factory_expence', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_list}}', 'factory_expence');
    }
}
