<?php

use common\models\ProductList;
use common\models\Units;
use kartik\widgets\SwitchInput;
use soft\widget\kartik\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductList */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="product-list-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'product_name')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'type_id')->dropDownList(ProductList::types()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'size_type_id')->dropDownList(Units::getMap()) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'selling_price_uz')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col md-6">
                <?= $form->field($model, 'residue')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="display:none;" id="expence">
                <?= $form->field($model, 'factory_expence')->textInput() ?>
            </div>
        </div>
        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>
        <?php ActiveForm::end(); ?>

    </div>
<?php
$js = <<< JS
  $('#productlist-type_id').change(function (){
       var id=$(this).find("option:selected").val();
       if (id==2){
           $('#expence').css('display','block')
       }
       else {
           $('#expence').css('display','none')
       }
  })
JS;
$this->registerJs($js);

?>