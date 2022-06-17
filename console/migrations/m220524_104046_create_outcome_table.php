<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%outcome}}`.
 */
class m220524_104046_create_outcome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%outcome}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'product_type_id' => $this->integer(),
            'size'=> $this->float(),
            'count'=> $this->float(),
            'total_size'=> $this->float(),
            'total'=> $this->float(),
            'unit_id'=> $this->integer(),
            'discount'=> $this->float(),
        ]);
        $this->addForeignKey('fk_outcome_client', '{{%outcome}}', 'client_id', '{{%client}}', 'id','CASCADE','CASCADE');
        $this->addForeignKey('fk_outcome_product_type', '{{%outcome}}', 'product_type_id', '{{%product_list}}', 'id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_outcome_client', '{{%outcome}}');
        $this->dropForeignKey('fk_outcome_product_type', '{{%outcome}}');
        $this->dropTable('{{%outcome}}');
    }
}
