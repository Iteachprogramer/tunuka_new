<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_last_updated_column_to_client}}`.
 */
class m220525_074910_create_add_last_updated_column_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->addColumn('{{%client}}','last_updated',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}','last_updated');
    }
}
