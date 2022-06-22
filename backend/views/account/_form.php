<?php

use common\models\Client;
use common\models\Employees;
use soft\helpers\ArrayHelper;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\DatePicker;
use soft\widget\kartik\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?php if ($model->client_id):?>
            <?php if (!$model->is_main): ?>
                    <?= $form->field($model, 'client_id')->widget(\kartik\select2\Select2::class, [
                        'data' => Client::getMap(),
                        'options' => [
                            'placeholder' => 'Klientni tanlang...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]) ?>
            <?php else: ?>
                <h3 class="text-primary" align="center">Boshlang'ich kassa</h3>
            <?php endif ?>
            <?php else:?>
                <?= $form->field($model, 'employee_id')->widget(\kartik\select2\Select2::class, [
                    'data' => ArrayHelper::map(Employees::find()->andWhere(['status'=> Employees::STATUS_ACTIVE])->all(),'id','name'),
                    'options' => [
                        'placeholder' => 'Ishcini tanlang...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]) ?>
            <?php endif;?>
        </div>
        <div class="col-md-6">


            <?= $form->field($model, 'date')->widget(DatePicker::class) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'sum')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'dollar')->textInput() ?>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'dollar_course')->textInput() ?></div>
            <div class="col-md-6"><?= $form->field($model, 'bank')->textInput() ?></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
