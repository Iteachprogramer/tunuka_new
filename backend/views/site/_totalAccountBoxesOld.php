<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 02.07.2021, 14:40
 */

use backend\models\Client;
use soft\widget\adminlte3\InfoBoxWidget;

/* @var $this \soft\web\View */
/* @var $allClients Client[] */

$qarzlar = 0;
$haqlar = 0;

foreach ($allClients as $client) {
    $finishAccount = $client->finishAccount;
    if ($finishAccount > 0) {
        $haqlar += $finishAccount;
    } else {
        $qarzlar += $finishAccount;
    }
}

$asosiyKassa = \backend\models\Account::findOne(['is_main' => true]);
$boshlangichKassaQiymati = $asosiyKassa->total;

?>

<div class="row">

    <div class="col-md-3 col-sm-6 col-6">
        <?= InfoBoxWidget::widget([
            'options' => ['class' => 'bg-success'],
            'text' => 'Umumiy',
            'textOptions' => ['class' => 'h5'],
            'icon' => false,
            'number' => as_integer($haqlar + $qarzlar + $boshlangichKassaQiymati),
            'numberOptions' => ['class' => 'h5']
        ]) ?>
    </div>

    <div class="col-md-3 col-sm-6 col-6">
        <?= InfoBoxWidget::widget([
            'text' => "Haqlar",
            'options' => ['class' => 'bg-info'],
            'textOptions' => ['class' => 'h5'],
            'icon' => false,
            'number' => as_integer($haqlar),
            'numberOptions' => ['class' => 'h5']
        ]) ?>
    </div>
    <div class="col-md-3 col-sm-6 col-6">
        <?= InfoBoxWidget::widget([
            'text' => "Qarzlar",
            'options' => ['class' => 'bg-warning'],
            'textOptions' => ['class' => 'h5'],
            'icon' => false,
            'number' => as_integer($qarzlar),
            'numberOptions' => ['class' => 'h5']
        ]) ?>
    </div>

    <div class="col-md-3 col-sm-6 col-6">
        <?= InfoBoxWidget::widget([
            'text' => "Boshlang'ich kassa",
            'options' => ['class' => 'bg-primary'],
            'textOptions' => ['class' => 'h6'],
            'icon' => false,
            'number' => as_integer($boshlangichKassaQiymati),
            'numberOptions' => ['class' => 'h5']
        ]) ?>
    </div>

</div>