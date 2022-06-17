<?php


/* @var $this soft\web\View */
/* @var $model backend\modules\usermanager\models\User */

$this->title = 'Foydalanuvchi qo\'shish';
$this->params['breadcrumbs'][] = ['label' =>'Foydalanuvchilar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>



<?= $this->render('_form', [
    'model' => $model,
]) ?>