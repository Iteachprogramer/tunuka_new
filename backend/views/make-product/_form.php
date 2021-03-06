<?php

use common\models\Employees;
use common\models\ProductList;
use soft\helpers\Url;
use soft\widget\kartik\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MakeProduct */
/* @var $form yii\widgets\ActiveForm */
$product_lists = ProductList::find()->andWhere(['type_id' => ProductList::TYPE_RULON])->all();
$arr = [];
foreach ($product_lists as $key => $product_list) {
    if ($product_list->residual > 0) {
        $arr[$product_list->id] = $product_list->product_name;
    }
}
?>

    <div class="make-product-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'employee_id', ['inputOptions' => ['tabindex' => '1']])->widget(Select2::class, [
                    'data' => Employees::getMap(),
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'product_id', ['inputOptions' => ['tabindex' => '1']])->widget(Select2::class, [
                    'data' => $arr,
                ]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'size', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '1']])->textInput(['maxlength' => true,]) ?>
            </div>
            <div class="col-md-3">
                <label>Mahsulot qoldig'i</label>
                <input type="text" id="outcome_product_residue" disabled class="form-control"
                       value="0">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'produced_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->widget(Select2::class, [
                    'data' => ProductList::getProduct()
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'factory_size', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->textInput() ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'comment', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '4']])->textarea([
                    'rows' => 1
                ]) ?>

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
$url = Url::to(['make-product/product-type']);
$js = <<< JS
$(document).ready(function (){
$('#makeproduct-size').focus();
$('#makeproduct-product_id').on('change', function() {
    var val=$(this).val();
    $.ajax({
        url: '{$url}',
        type: 'POST',
        data: {id: val},
        success: function(data) {
            $('#outcome_product_residue').val(data.residual);
        }
    });
});

})
JS;
$this->registerJs($js)
?>