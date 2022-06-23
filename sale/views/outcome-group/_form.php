<?php

use common\models\Client;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\DatePicker;
use soft\widget\kartik\DateTimePicker;
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
            <?= $form->field($model, 'phone_client_id',['inputOptions'=>['id'=>'phone-client']])->widget(Select2::class,[
                'data' => Client::getClientPhone(),
                'options' => ['placeholder' => 'Mijoz ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'date')->widget(DateTimePicker::className(),[
                'options' => ['placeholder' => 'Vaqtni tanlang...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy hh:ii:ss'
                ]
            ]) ?>

        </div>
    </div>



    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
