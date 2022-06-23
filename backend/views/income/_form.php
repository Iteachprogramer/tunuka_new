<?php

use common\models\Client;
use common\models\DollarCourse;
use common\models\Income;
use common\models\ProductList;
use kartik\date\DatePicker;
use soft\helpers\ArrayHelper;
use soft\helpers\Url;
use soft\widget\kartik\DateRangePicker;
use soft\widget\kartik\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Income */
/* @var $form yii\widgets\ActiveForm */
$course = DollarCourse::find()->orderBy(['id' => SORT_DESC])->one();
?>

    <div class="income-form">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-7">
                <?= $form->field($model, 'product_type_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '1']])->widget(Select2::class, [
                    'data' => ArrayHelper::map(ProductList::find()->andWhere(['!=', 'type_id', ProductList::TYPE_PRODUCT])->all(), 'id', 'product_name'),
                    'options' => ['placeholder' => 'Mahsulot turini tanlang ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-md-5">
                <label>Mahsulot qoldig'i</label>
                <input type="number" disabled class="form-control" id="residual"
                       value="<?= $model->productType->residual ? number_format($model->productType->residual, 2, '.', '') : 0 ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <?= $form->field($model, 'provider_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->widget(Select2::class, [
                    'data' => Client::getProvider(),
                    'options' => ['placeholder' => 'Klientni tanlang ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-md-5">
                <label>Qarzi yoki haqi</label>
                <input type="text" disabled class="form-control"
                       value="<?= number_format(abs($model->provider->finishAccountSum), 0, ' ', ' ') . ' so\'m' . '/' . number_format($model->provider->finishAccountSumDollar) . ' $'; ?>"
                       id="debt">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label id="weight-label">Og'irligi</label>
                <div id="weight">
                    <?= $form->field($model, 'weight', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->textInput()->label(false) ?>
                </div>
                <label>Birlik</label>

                <input type="text" class="form-control" disabled
                       value="<?= $model->unityType->name ?>" id="income-unity_type_id">

            </div>
            <div class="col-md-3">
                <label id="price-label">1 tonna uchun narx</label>
                <?= $form->field($model, 'cost', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '4']])->textInput()->label(false) ?>
                <div id="length" style="<?php
                if ($model->productType->sizeType->id == 2 || $model->isNewRecord) {
                    echo 'display:block';
                } else {
                    echo 'display:none';
                }
                ?>">
                    <label> Umumiy necha metr</label>
                    <?= $form->field($model, 'length', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '6']])->textInput()->label(false) ?>
                </div>

            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'cost_of_living', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '5']])->textInput() ?>
                <div id="price_per" style="
                <?php if ($model->productType->sizeType->id == 2 || $model->isNewRecord) {
                    echo 'display:block';
                } else {
                    echo 'display:none';
                }
                ?>; margin-top: 16px">
                    <?= $form->field($model, 'price_per_meter', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '-1']])->textInput() ?>
                </div>
            </div>
            <div class="col-md-3">
                <label>Umumiy summa</label>
                <input
                        type="text" id="income-total" class="form-control"
                        disabled
                        value="<?= number_format($model->total, 0, ' ', ' ') ?>">
            </div>
        </div>
        <?php if (!Yii::$app->request->isAjax) { ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','tabindex'=>'7']) ?>
            </div>
        <?php } ?>
        <?php ActiveForm::end(); ?>
    </div>
<?php
$course = DollarCourse::find()->one();
?>
    <input type="hidden" value="<?= $course->course ?>" name="course">

<?php
$url = Url::to(['income/product-type']);
$url_provider = Url::to(['income/provider']);
$js = <<<JS
$('#income-product_type_id').on('change', function() {
    var val=$(this).val();
    $.ajax({
        url: '{$url}',
        type: 'POST',
        data: {id: val},
        success: function(data) {
            let type_id =data.product_list.type_id;
            $('#income-unity_type_id').val(data.product_list.size_type_id);
            if (type_id===2 || type_id === 1)
            {
                $('#length').css('display','none');
                $('#price_per').css('display','none');
                $('#price-label').text('Narx');
                $('#weight-label').text('Miqdori');
            }
            else if (type_id===3)
            {
                $('#length').css('display','block');
                $('#price_per').css('display','block');
                $('#price-label').text('1 tonna uchun narx');
                $('#weight-label').text('Og\'irligi');
            }
            $('#residual').val(data.residual);
        }
    });
});
$('#income-provider_id').on('change',function (){
        var val=$(this).val();
            $.ajax({
        url: '{$url_provider}',
        type: 'POST',
        data: {id: val},
        success: function(data) {
           let debt_new= data.debt
            $('#debt').val(debt_new +' so\'m' + '/' + data.debt_dollar + ' $');
        }
    });
})
$("#income-cost").on('keydown',function (e){
     if (e.key === 'Enter' || e.keyCode === 13 || e.key === 'Tab')
     {
         var sum=0;
    let val=$(this).val();
    let weight=$('#income-weight').val();
    let cost_tye=$('#income-cost_type').val();
     sum= val * weight;
    let length=$('#income-length').val();
  if (length!=0)
  {
          let per_metr=sum/length;
          $('#income-price_per_meter').val(per_metr.toFixed(2))
  }
    $('#income-total').val(sum.toLocaleString())
      
     }
  });
$("#income-length").on('keydown',function (e){
     if (e.key === 'Enter' || e.keyCode === 13 || e.key === 'Tab')
     {
          var total=0;
          let val=$(this).val();
          let income_cost=$('#income-cost').val();
          let weight=$('#income-weight').val();
          let cost_tye=$('#income-cost_type').val();
          total=  weight *income_cost;
       if (val!=0)
       {
           let per_metr=total/val;
           $('#income-price_per_meter').val(per_metr.toFixed(2))

           }
     }
  });
JS;
$this->registerJs($js);

?>