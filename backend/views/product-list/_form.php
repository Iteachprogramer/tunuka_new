<?php

use common\models\ProductList;
use common\models\Units;
use kartik\widgets\SwitchInput;
use soft\helpers\Url;
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
                <?= $form->field($model, 'type_id')->dropDownList(ProductList::types(),['prompt'=>'Mahsulot turini tanlang ...']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'size_type_id')->dropDownList(Units::getMap()) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'selling_price_uz',['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col md-6">
                <?= $form->field($model, 'residue',['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->textInput() ?>
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
$url = Url::to(['product-list/units']);
$js = <<< JS
  $('#productlist-type_id').change(function ()
  {
       var id=$(this).find("option:selected").val();
       if (id==2){
           $('#expence').css('display','block')
       }
       else {
           $('#expence').css('display','none')
       }
         $.ajax({
        url: '{$url}',
        type: 'POST',
        data: {id: id},
        success: function(data) {
           if (id!=1)
           {
               let rulon="<option value='"+data['units'][0]['id']+"'>"+data['units'][0]['name']+"</option>"
               $('#productlist-size_type_id').html(rulon)
           }
           else {
               $('#productlist-size_type_id').html(
                   "<option value='"+data['units'][1]['id']+"'>"+data['units'][1]['name']+"</option>"+
                    "<option value='"+data['units'][2]['id']+"'>"+data['units'][2]['name']+"</option>"
                   )
           }
        }
    });
  })
JS;
$this->registerJs($js);

?>