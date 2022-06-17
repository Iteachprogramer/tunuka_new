<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_date_column_to_make_product}}`.
 */
class m220531_085717_create_add_date_column_to_make_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%make_product}}', 'date', $this->integer());
        $this->addColumn('{{%make_product}}', 'total_expence', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%make_product}}', 'date');
       $this->dropColumn('{{%make_product}}', 'total_expence');
    }
}
