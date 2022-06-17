<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MakeProductItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="make-product-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'income_id')->textInput() ?>

    <?= $form->field($model, 'make_id')->textInput() ?>

    <?= $form->field($model, 'outcome_size')->textInput() ?>

    <?= $form->field($model, 'residue_size')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
