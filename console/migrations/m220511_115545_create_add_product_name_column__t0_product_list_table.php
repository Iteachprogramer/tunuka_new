<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_product_name_column__t0_product_list}}`.
 */
class m220511_115545_create_add_product_name_column__t0_product_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->addColumn('{{%product_list}}','product_name',$this->string()->after('id'));
       $this->addColumn('{{%product_list}}','selling_rentail_usd',$this->float()->after('selling_rentail'));
       $this->addColumn('{{%product_list}}','surface_type',$this->integer()->after('selling_rentail_usd'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_list}}','product_name');
        $this->dropColumn('{{%product_list}}','selling_rentail_usd');
        $this->dropColumn('{{%product_list}}','surface_type');
    }
}
