<?php

use common\models\Client;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\DatePicker;
use soft\widget\kartik\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OutcomeGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outcome-group-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'client_id')->widget(Select2::class,[
                'data' => Client::getClient(),
                'options' => ['placeholder' => 'Mijoz ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date')->widget(DatePicker::className()) ?>

        </div>
    </div>



    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
