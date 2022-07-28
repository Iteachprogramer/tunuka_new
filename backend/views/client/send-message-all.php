<?php


/* @var $this View */
/* @var $model SendMessage */
/* @var $pks false|string[] */
?>
<?php


/* @var $this View */

/* @var $model SendMessage */

use common\models\SendMessage;
use soft\helpers\Html;
use soft\helpers\Url;
use soft\widget\bs4\Card;
use soft\widget\kartik\ActiveForm;
use yii\web\View;

?>
<?php $form = ActiveForm::begin(['action' => Url::to(['client/send-message-check'])]); ?>
<?= $form->field($model, 'message')->textarea() ?>
<div class="form-group">
    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton('Yuborish', ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?></div>
<?php ActiveForm::end() ?>

