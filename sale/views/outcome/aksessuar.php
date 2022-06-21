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
        #price_usd {
            color: #f1fbe5;
        }
    </style>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'client_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '1']])->widget(Select2::class, [
                'data' => Client::getClient(),
                'disabled' => true,
                'options' => ['placeholder' => 'Mijozni tanlang ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <label>Oldi berdi</label>
            <input type="text" id="client_debt" disabled class="form-control"
                   value="<?= $model->client->finishAccountSum . ' / ' . $model->client->finishAccountSumDollar . ' $' ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'product_type_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->widget(Select2::class, [
                'data' => ProductList::getNotRulon(),
                'options' => ['placeholder' => 'Mahsulotni  tanlang ...'],
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
                    <label id="label">Mahsulot narxi</label>
                    <input type="text" id="price_usd" disabled class="form-control"
                           value="<?= $model->isNewRecord ? 0 : as_integer($model->productType->selling_price_uz) ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="type_product"
                <?php if ($model->productType->type_id == ProductList::TYPE_AKSESSUAR  || !$model->productType->type_id): ?>
                    style="display: none"
                <?php endif; ?>
            >
                <?= $form->field($model, 'total_size', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->textInput() ?>
            </div>
            <div
                <?php if ($model->productType->type_id == ProductList::TYPE_PRODUCT): ?>
                    style="display: none"
                <?php endif; ?>
                    class="type_akksessuar">
                <?= $form->field($model, 'count', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->textInput() ?>
            </div>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'cost', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '4']])->textInput() ?>
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
            if (data.type === 'metr') 
            {
                $('.type_akksessuar').css('display', 'none');
                $('.type_product').css('display', 'block');
            } else {
                 $('.type_akksessuar').css('display', 'block');
                $('.type_product').css('display', 'none');
            }
            if (data.product_list.selling_price_usd){
                $('#price_usd').val(data.product_list.selling_price_usd);
                $('#label').text('Mahsulot narxi dollar');
            }
            else{
                $('#price_usd').val(data.product_list.selling_price_uz.toLocaleString());
                $('#label').text('Mahsulot narxi so\'m');
            }
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
         let count=$('#outcome-count').val();
         if (size && size!=0){
              let total=val*size;
              $('#outcome-total').val(total.toLocaleString());
         }
         if (count && count!=0)
             {
                 let total=val*count;
                 $('#outcome-total').val(total.toLocaleString());
             }
     }
  });
JS;
$this->registerJs($js)
?>