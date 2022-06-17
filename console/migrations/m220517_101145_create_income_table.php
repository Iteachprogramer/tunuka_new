<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%income}}`.
 */
class m220517_101145_create_income_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%income}}', [
            'id' => $this->primaryKey(),
            'product_type_id' => $this->integer(),
            'cost' => $this->float()->comment('1 tonna uchun narx'),
            'provider_id' => $this->integer()->comment('Ta\minotchi'),
            'weight' => $this->float()->comment('qancha umumiy tonna mahsulot kelgani yoziladi'),
            'length' => $this->float()->comment('umumiy necha metr ekanligi'),
            'cost_of_living' => $this->float()->comment('umumiy necha metr ekanligi'),
            'dollar_course' => $this->float()->comment('Sotib olayotgan vaqtdagi  kurs narxi'),
            'total' => $this->float()->comment('Umumiy summa'),
            'price_per_meter' => $this->float()->comment('1 metr uchun narx'),
            'unity_type_id' => $this->integer()->comment('Birlik turi'),
            'created_at' => $this->integer()->comment('Yaratilgan vaqt'),
            'updated_at' => $this->integer()->comment('O\'zgartirilgan vaqt'),
            'created_by' => $this->integer()->comment('Yaratgan'),
            'updated_by' => $this->integer()->comment('O\'zgartirgan'),
            'date' => $this->integer()->comment('Yuk olingan sana'),
        ]);
        $this->addForeignKey('fk_income_product_type_id', '{{%income}}', 'product_type_id', '{{%product_list}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_income_provider_id', '{{%income}}', 'provider_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_income_unity_type_id', '{{%income}}', 'unity_type_id', '{{%units}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_income_created_by', '{{%income}}', 'created_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_income_updated_by', '{{%income}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_income_product_type_id', '{{%income}}');
        $this->dropForeignKey('fk_income_provider_id', '{{%income}}');
        $this->dropForeignKey('fk_income_unity_type_id', '{{%income}}');
        $this->dropForeignKey('fk_income_created_by', '{{%income}}');
        $this->dropForeignKey('fk_income_updated_by', '{{%income}}');
        $this->dropTable('{{%income}}');
    }
}
