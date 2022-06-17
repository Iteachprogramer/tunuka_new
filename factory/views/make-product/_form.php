<?php

use common\models\Employees;
use common\models\ProductList;
use soft\widget\kartik\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MakeProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="make-product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'employee_id',['inputOptions' => ['tabindex' => '1']])->widget(Select2::class,[
                    'data' => Employees::getMap(),
            ]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'product_id',['inputOptions' => ['tabindex' => '1']])->widget(Select2::class,[
                    'data' => ProductList::getRulon(),
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'size',['inputOptions' => ['class' => 'form-control', 'tabindex' => '1']])->textInput(['maxlength' => true,]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'produced_id',['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->widget(Select2::class,[
                'data' => ProductList::getProduct()
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'factory_size',['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'comment',['inputOptions' => ['class' => 'form-control', 'tabindex' => '4']])->textarea([
                    'rows'=>1
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
