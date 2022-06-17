<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_per_metr_expence_and_price_columns_to_make_product}}`.
 */
class m220606_054451_create_add_per_metr_expence_and_price_columns_to_make_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%make_product}}','per_metr_expence',$this->integer());
        $this->addColumn('{{%make_product}}','per_metr_cost',$this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%make_product}}','per_metr_expence');
       $this->dropColumn('{{%make_product}}','per_metr_cost');
    }
}
