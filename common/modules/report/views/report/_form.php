<?php

use common\models\Employees;
use kartik\time\TimePicker;
use soft\widget\kartik\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\report\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->widget(Select2::class,[
        'data' => Employees::getMap(),
        'options' => [
            'placeholder' => 'Hodimni tanlang...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ]
    ]) ?>
    <?= $form->field($model, 'start_day')->widget(TimePicker::class,[
        'pluginOptions' => [
            'showSeconds' => true,
            'showMeridian' => false,
        ]
    ]) ?>
    <?= $form->field($model, 'end_day')->widget(TimePicker::class,[
        'pluginOptions' => [
            'showSeconds' => true,
            'showMeridian' => false,
        ]
    ]) ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
