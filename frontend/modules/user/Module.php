<?php

namespace frontend\modules\user;

use soft\helpers\SiteHelper;
use Yii;
use yii\web\ErrorHandler;

/**
 * tutor module definition class
 */
class Module extends \yii\base\Module
{
    public $defaultRoute = 'default/home';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!user()) {
            forbidden();
        }
        $this->findLayout();

        parent::init();

        $config = require(__DIR__ . '/config/main.php');

        Yii::configure(Yii::$app, $config);

        SiteHelper::setLanguage();

        /** @var ErrorHandler $handler */
        $handler = $this->get('errorHandler');
        Yii::$app->set('errorHandler', $handler);
        $handler->register();
    }

    private function findLayout()
    {
        $this->layoutPath = '@frontend/modules/branch/views/layouts';
    }
}
