<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%make_product}}`.
 */
class m220530_131412_create_make_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%make_product}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'size'=>$this->float(),
            'produced_id'=>$this->integer(),
            'shape_id'=>$this->integer(),
            'type_id'=>$this->integer(),
            'factory_size'=>$this->float(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk_make_product_employee','{{%make_product}}','employee_id','{{%employees}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk_make_product_product','{{%make_product}}','product_id','{{%product_list}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk_make_product_produced','{{%make_product}}','produced_id','{{%product_list}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk_make_product_shape','{{%make_product}}','shape_id','{{%shapes}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk_make_product_created_by','{{%make_product}}','created_by','{{%user}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk_make_product_updated_by','{{%make_product}}','updated_by','{{%user}}','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_make_product_employee','{{%make_product}}');
        $this->dropForeignKey('fk_make_product_product','{{%make_product}}');
        $this->dropForeignKey('fk_make_product_produced','{{%make_product}}');
        $this->dropForeignKey('fk_make_product_shape','{{%make_product}}');
        $this->dropForeignKey('fk_make_product_created_by','{{%make_product}}');
        $this->dropForeignKey('fk_make_product_updated_by','{{%make_product}}');
        $this->dropTable('{{%make_product}}');
    }
}
