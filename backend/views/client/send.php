<?php


/* @var $this View */
/* @var $model SendMessage */

use common\models\SendMessage;
use soft\helpers\Html;
use soft\widget\bs4\Card;
use soft\widget\kartik\ActiveForm;
use yii\web\View;

?>
<?php Card::begin()?>
<?php $form = ActiveForm::begin(); ?>
<?=$form->field($model,'message')->textarea()?>
<div class="form-group">
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton('Yuborish', ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?></div>
<?php ActiveForm::end()?>
<?php Card::end()?>
