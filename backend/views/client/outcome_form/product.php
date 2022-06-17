<?php


use common\models\Client;
use common\models\Outcome;
use common\models\ProductList;
use soft\helpers\Url;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\DatePicker;
use soft\widget\kartik\Select2;

/** @var Outcome $model */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'product_type_id')->widget(Select2::class, [
                'data' => ProductList::getProduct(),
                'options' => ['placeholder' => 'Mahsulotni  tanlang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <label>Mahsulot qoldig'i</label>
                    <input type="text" id="outcome_product_residue" disabled class="form-control"
                           value="<?= $model->isNewRecord ? 0 : number_format($model->productType->residual, 2, '.', ' ') ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?=$form->field($model,'total_size')->textInput()?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'cost')->textInput() ?>
        </div>
        <div class="col-md-3">
            <label>Umumiy summa</label>
            <input type="text" id="outcome-total" disabled class="form-control"
                   value="<?= $model->isNewRecord ? 0 : as_integer($model->total) ?>">
        </div>
        <div class="col-md-3">
            <label>Birlik</label>
            <input type="text" class="form-control" disabled id="outcome-unity"
                   value="<?= $model->isNewRecord ? '' : $model->unity->name ?>">
        </div>
    </div>
<?php ActiveForm::end() ?>
<?php
$url = Url::to(['outcome/product-type']);
$url_provider = Url::to(['outcome/provider']);
$js = <<< JS
$('#outcome-product_type_id').on('change', function() {
    var val=$(this).val();
    $.ajax({
        url: '{$url}',
        type: 'POST',
        data: {id: val},
        success: function(data) {
            $('#outcome_product_residue').val(data.residual);
            $('#outcome-unity').val(data.type)
            $('#price_usd').val(data.product_list.selling_price_usd);
        }
    });
});
$('#outcome-client_id').on('change',function (){
        var val=$(this).val();
            $.ajax({
        url: '{$url_provider}',
        type: 'POST',
        data: {id: val},
        success: function(data) {
           let debt_new= data.debt
            $('#client_debt').val(debt_new+' / '+data.debt_dollar+' $')
        }
    });

})
$("#outcome-cost").on('keydown',function (e){
    if (e.key === 'Enter' || e.keyCode === 13 || e.key === 'Tab')
     {
         var discount=0;
         let val=$(this).val();
         let size=$('#outcome-total_size').val();
         let total=val*size;
         $('#outcome-total').val(total.toLocaleString());
     }
  });
JS;

$this->registerJs($js)
?>