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
<style>
    #price_usd{
        color: #f1fbe5;
    }
</style>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'options' => [
        'validateOnSubmit' => true,
    ],
]); ?>
<?php //echo $form->errorSummary($model)?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'client_id')->widget(Select2::class, [
                'disabled' => true,
                'data' => Client::getClient(),
                'options' => ['placeholder' => 'Mijozni tanlang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <label>Oldi berdi</label>
            <input type="text" id="client_debt" disabled class="form-control"
                   value="<?=$model->client->finishAccountSum . ' / ' . $model->client->finishAccountSumDollar . ' $' ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'product_type_id',['inputOptions' => ['class' => 'form-control', 'tabindex' => '-1']])->widget(Select2::class, [
                'data' => ProductList::getRulon(),
                'options' => ['placeholder' => 'Ruloni tanlang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label>Mahsulot qoldig'i</label>
                    <input type="text" id="outcome_product_residue" disabled class="form-control"
                           value="<?= number_format($model->residual, 2, '.', ' ') ?>">
                </div>
                <div class="col-md-6">
                    <label>Mahsulot narxi dolarda</label>
                    <input type="text" id="price_usd" disabled class="form-control"
                           value="<?= $model->isNewRecord ? 0 : as_integer($model->productType->selling_price_usd) ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'size',['inputOptions' => ['autofocus' => true,'class' => 'form-control', 'tabindex' => '1','required'=>true]])->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'count',['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->textInput()->label('Soni') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'cost',['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'total_size')->textInput([
                    'disabled'=>true
            ]) ?>
        </div>
    </div>
    <div class="row">
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
$('#outcome-size').focus();
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
$("#outcome-count").on('keydown',function (e){
    if (e.key === 'Enter' || e.keyCode === 13 || e.key === 'Tab')
     {
         var discount=0;
          let val=$(this).val();
         let size=$('#outcome-size').val();
         let cost=$('#outcome-cost').val();
         if (cost){
             let total=val*size*cost;
             $('#outcome-total').val(total);
         }
         let total=val*size;
         $('#outcome-total_size').val(total.toFixed(2));
     }
  });
$("#outcome-cost").on('keydown',function (e){
    if (e.key === 'Enter' || e.keyCode === 13 || e.key === 'Tab')
     {
         var discount=0;
         let val=$(this).val();
         let count=$('#outcome-count').val();
         let size=$('#outcome-size').val();
         discount=$('#outcome-discount').val();
         let total=val*size * count;
         $('#outcome-total').val(total.toLocaleString());
     }
  });
JS;
$this->registerJs($js)
?>