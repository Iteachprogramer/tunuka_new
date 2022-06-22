<?php


/* @var $this View */
/* @var $cash Account */

/* @var $group array|OutcomeGroup|null|ActiveRecord */

use common\models\Account;
use common\models\OutcomeGroup;
use soft\helpers\Html;
use soft\widget\bs4\Card;
use soft\widget\kartik\ActiveForm;
use yii\db\ActiveRecord;
use yii\web\View;
$this->title='To\'lov';
echo $this->render('info', ['group' => $group])
?>
<?php Card::begin() ?>
<?php $form = ActiveForm::begin([
    'action' => ['outcome/payment','id'=>$group->id],
]) ?>
    <div class="row">
        <div class="col-md-3">
            <label>Summa</label>
            <input type="text" value="<?= number_format($group->outcomeSum,0,' ',' ') ?>" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <?= $form->field($group, 'discount')->textInput() ?>
        </div>
        <div class="col-md-3">
            <label>To'lanadigan summa</label>
            <input type="text" disabled class="form-control" id="finish_sum" value="<?=$group->isNewRecord?0:as_integer($group->total)?>">
        </div>
        <div class="col-md-3">
            <?= $form->field($group, 'where')->textInput() ?>
        </div>
    </div>

    <input type="hidden" value="<?= $group->outcomeSum ?>" name="sum">
    <div class="form-group">
        <?= Html::submitButton($group->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $group->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>
<?php Card::end() ?>

<?php
$js = <<< JS
$("#outcomegroup-discount").on('keydown',function (e){
    if (e.key === 'Enter' || e.keyCode === 13 || e.key === 'Tab')
     {
         var discount=0;
         let val=$(this).val();
         let sum=$('input[name=sum]').val()
             let total_sum=sum-val;
             $('#finish_sum').val(total_sum);
         $('#outcome-total_size').val(total.toLocaleString());
     }
  });

JS;
$this->registerJs($js);
?>