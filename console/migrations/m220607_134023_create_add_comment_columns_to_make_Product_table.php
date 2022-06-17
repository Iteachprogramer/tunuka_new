<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_comment_columns_to_make_Product}}`.
 */
class m220607_134023_create_add_comment_columns_to_make_Product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%make_product}}','comment',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%make_product}}','comment');
    }
}
