<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model backend\modules\usermanager\models\User */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Foydalanuvchi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>'', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

