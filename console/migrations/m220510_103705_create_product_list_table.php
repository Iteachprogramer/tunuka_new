<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_list}}`.
 */
class m220510_103705_create_product_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_list}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(),
            'residue' => $this->float(),
            'sort_order' => $this->integer(),
            'size_type_id' => $this->integer(),
            'selling_price_uz' => $this->float(),
            'selling_price_usd' => $this->float(),
            'selling_rentail' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer(),
        ]);
        $this->addForeignKey('fk_product_list_size_type_id', '{{%product_list}}', 'size_type_id', '{{%units}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_list_created_by', '{{%product_list}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_list_updated_by', '{{%product_list}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_product_list_size_type_id', '{{%product_list}}');
        $this->dropForeignKey('fk_product_list_created_by', '{{%product_list}}');
        $this->dropForeignKey('fk_product_list_updated_by', '{{%product_list}}');
        $this->dropTable('{{%product_list}}');
    }
}
