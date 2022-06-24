<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 02.07.2021, 15:25
 */

use backend\models\Client;
use soft\helpers\ArrayHelper;
use soft\helpers\Html;

/* @var $this \soft\web\View */

$clientTypes = Client::types();
$type_id = Yii::$app->request->get('type_id');
$currentTypeName = ArrayHelper::getArrayValue($clientTypes, $type_id, 'Barchasi');

$sorts = [
    'name' => "Ismi o'sish",
    '-name' => "Ismi kamayish",
    'money' => "Puli o'sish",
    '-money' => "Puli kamayish",
    'haqdor' => "Haqdorlar",
    'qarzdor' => "Qarzdorlar",
];

$currentSort = Yii::$app->request->get('sort');

?>

<?= Html::beginForm(['site/index'], 'get', ['id' => 'client_filter_form']) ?>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Klientlarni qidirish" aria-label="Klientlarni qidirish"
                   name="client_name" value="<?= Yii::$app->request->get('client_name') ?>" id="client_name_input"
                   style="min-width: 25%">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="btn-group mb-3">
            <?= Html::dropDownList('type_id', $type_id, $clientTypes, [
                'class' => 'btn btn-default dropdown-toggle',
                'id' => 'client_type_select',
                'prompt' => 'Barchasi',
            ]) ?>
            <?= Html::dropDownList('sort', $currentSort, $sorts, [
                'class' => 'btn btn-default dropdown-toggle pl-0 pr-0',
                'id' => 'client_type_select',
                'prompt' => "Boshlang'ich",
            ]) ?>
            <button class="btn btn-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
            <a class="btn btn-danger" href="<?= to(['site/index']) ?>" id="reset_filter_button">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
</div>

<?= Html::endForm() ?>
