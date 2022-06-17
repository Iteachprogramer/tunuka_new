<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@soft', dirname(dirname(__DIR__)) . '/soft');
Yii::setAlias('@sale', dirname(dirname(__DIR__)) . '/sale');
Yii::setAlias('@factory', dirname(dirname(__DIR__)) . '/factory');
Yii::setAlias('@cash', dirname(dirname(__DIR__)) . '/cash');
Yii::setAlias('@homeUrl', '/');
Yii::$container->set('yii\data\Pagination', [
    'pageSizeLimit' => [1, 1000],
]);
