<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_make_product_item}}`.
 */
class m220608_110931_create_add_make_product_item_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%make_product_item}}', [
            'id' => $this->primaryKey(),
            'income_id' => $this->integer()->notNull(),
            'make_id' => $this->integer()->notNull(),
            'outcome_size' => $this->float(),
            'residue_size' => $this->float(),
        ]);
        $this->addForeignKey('fk_make_product_item_income', '{{%make_product_item}}', 'income_id', '{{%income}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_make_product_item_make', '{{%make_product_item}}', 'make_id', '{{%make_product}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_make_product_item_income', '{{%make_product_item}}');
        $this->dropForeignKey('fk_make_product_item_make', '{{%make_product_item}}');
        $this->dropTable('{{%make_product_item}}');
    }
}
