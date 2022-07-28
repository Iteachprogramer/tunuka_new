<?php

use common\models\User;
use console\models\ConsoleUser;
use yii\db\Migration;

/**
 * Class m220728_102328_add_client_user
 */
class m220728_102328_add_client_user extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('client');
        if ($adminRole == null) {
            $adminRole = $auth->createRole('client');
            $auth->add($adminRole);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('client');
        if ($adminRole != null) {
            $auth->remove($adminRole);
        }
        return true;
    }
}
