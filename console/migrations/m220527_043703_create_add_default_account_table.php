<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%add_default_account}}`.
 */
class m220527_043703_create_add_default_account_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (parent::safeUp() !== false) {
            $this->insert('{{%account}}',
                [
                    'type_id' => 1,
                    'comment' => "Asosiy kassa",
                    'is_main' => true,
                    'created_at' => time()
                ]
            );
        }
    }


}
