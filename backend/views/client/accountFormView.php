<?php


use common\models\Account;
use common\models\Client;
use common\models\DollarCourse;
use soft\helpers\Html;
use soft\web\View;
use soft\widget\adminlte3\Card;
use soft\widget\input\SumMaskedInput;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\DatePicker;

/* @var $this View */
/* @var $model Account */
/* @var $client Client */
/* @var $title string */

$this->title = $title;

$this->addBreadCrumb('Klientlar', ['client/index']);
$this->addBreadCrumb($model->client->fulla_name, ['client/account', 'id' => $model->client->id]);
$this->addBreadCrumb($title);

if (empty($model->dollar_course)) {
    $model->dollar_course = DollarCourse::find()->orderBy(['id' => SORT_DESC])->one()->course;
}

$isAjax = $this->isAjax;

?>

<?php if (!$isAjax): ?>
    <?php Card::begin() ?>
<?php endif ?>
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'sum')->input('number') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'dollar')->input('number') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'bank')->input('number') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'dollar_course')->input('number', ['stpe' => 0.01]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'date')->widget(DatePicker::class, [
            'options' =>[ 'required' => true]
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'comment')->textarea(['rows' => 1]) ?>
    </div>
</div>

<?php if (!$this->isAjax): ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
    </div>
<?php endif ?>

<?php ActiveForm::end(); ?>

<?php if (!$isAjax): ?>
    <?php Card::end() ?>
<?php endif ?>

