<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Employees */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employees-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary')->textInput() ?>

    <?= $form->field($model, 'is_factory')->widget(SwitchInput::class,[
            'pluginOptions' => [
                'onText' => 'Ishlabchiqarish',
                'offText' => 'Ishlabchiqaruvchi emas',
            ]
    ]) ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::class,[
            'pluginOptions' => [
                'onText' => 'ishlayabdi',
                'offText' => 'ishlamayabdi',
            ]
    ]) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
