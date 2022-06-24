<?php


use common\models\Account;
use common\models\Client;
use common\models\Employees;
use common\models\ExpenseType;
use soft\helpers\ArrayHelper;
use soft\web\View;
use soft\widget\dynamicform\DynamicFormModel;
use soft\widget\kartik\DatePicker;
use kartik\select2\Select2;
use soft\widget\adminlte3\Card;
use soft\widget\dynamicform\DynamicFormWidget;
use soft\widget\kartik\ActiveForm;
$clientsMap = map(Client::find()->asArray()->all(), 'id', 'fulla_name');
?>
<p><a href="<?= to(['index']) ?>" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Ortga qaytish </a></p>

<?php Card::begin() ?>
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="row">
    <div class="col-md-4" style="display: none" id="client-debt"><input type="text" class="form-control" id="debt-input"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <?= DatePicker::widget([
            'name' => 'date',
            'value' =>Yii::$app->formatter->asDatetime(time(), 'php:d.m.Y'),
            'options' => ['required' => true],
        ]) ?>
    </div>
</div>
<br>
<?php DynamicFormWidget::begin([
    'form' => $form,
    'formId' => 'dynamic-form',
    'data' => $dform,
    'tableOptions' => ['class' => 'table table-condensed table-bordered', 'style' => ['min-width' => '600px']],
    'tableResponsiveClass' => 'table-responsive',
    'formFields' => [
        'name', 'status', 'type_id', 'phone'
    ],
    'columns' => [
        'client_id' => [
            'label' => 'Klient',
            'width' => '180px',
            'field' => function ($form, $model, $attribute) use ($clientsMap) {
                return $form->field($model, $attribute)->widget(Select2::class, [
                    'data' => $clientsMap,
                    'options' => [
                        'class' => 'client-test',
                        'placeholder' => 'Klientni tanlang...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])->label(false);
            },
        ],
        'employee_id' => [
            'label' => 'Ishchi',
            'width' => '130px',
            'field' => function ($form, $model, $attribute) use ($clientsMap) {
                return $form->field($model, $attribute)->widget(Select2::class, [
                    'data' => ArrayHelper::map(Employees::find()->andWhere(['status'=> Employees::STATUS_ACTIVE])->all(),'id','name'),
                    'options' => [
                        'placeholder' => 'Ishchini tanlang...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])->label(false);
            },
        ],
        'type_id' => [
            'label' => 'Pul',
            'width' => '120px',
            'field' => function ($form, $model, $attribute) {
                return $form->field($model, $attribute)->radioList([
                    Account::TYPE_INCOME => 'Oldim',
                    Account::TYPE_OUTCOME => 'Berdim',
                    Account::TYPE_EXPEND => 'Rasxod',
                ])->label(false);
            },
        ],
        'sum' => [
            'label' => "So'm",
            'field' => function ($form, $model, $attribute) {
                return $form->field($model, $attribute, ['enableClientValidation' => false])->input('number')->label(false);
            },
        ],
        'dollar' => [
            'label' => "Dollar",
            'field' => function ($form, $model, $attribute) {
                return $form->field($model, $attribute, ['enableClientValidation' => false])->input('number')->label(false);
            },
        ],
        'bank' => [
            'label' => "Bank",
            'field' => function ($form, $model, $attribute) {
                return $form->field($model, $attribute, ['enableClientValidation' => false])->input('number')->label(false);
            },
        ],
        'expense_type_id'=>[
            'label' => "Rasxod",
            'field' => function ($form, $model, $attribute) {
                return $form->field($model, $attribute)->dropDownList(ArrayHelper::map(ExpenseType::find()->where(['status'=> ExpenseType::STATUS_ACTIVE])->all(),'id','name'),['prompt'=>'Rasxod turini tanlang'])->label(false);
            },
        ],
        'comment',
    ]

]) ?>
<?php DynamicFormWidget::end() ?>
<?php ActiveForm::end(); ?>
<?php Card::end() ?>
<?php
$url=to(['account/debt-client']);
$js = <<<JS
    $(document).on('change','.client-test',function (){
        $('#debt-input').val('');
        var val=$(this).val();
        $.ajax({
        url: '{$url}',
        type: 'POST',
        data: {id: val},
        success: function(data) {
           let debt_new= data.debt
            $('#debt-input').val(debt_new+' / '+data.debt_dollar+' $');
           $('#client-debt').css('display','block');
        }
    });

})
JS;
$this->registerJs($js);
?>