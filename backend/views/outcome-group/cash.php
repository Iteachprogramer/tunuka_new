<?php

use common\models\Client;
use common\models\Employees;
use soft\helpers\ArrayHelper;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\DatePicker;
use soft\widget\kartik\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'sum')->textInput() ?>
        </div>  <div class="col-md-6">
            <?= $form->field($model, 'bank')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
