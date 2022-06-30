<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 02.07.2021, 14:40
 */

use common\models\Account;
use common\models\Client;

use common\models\ProductList;
use soft\web\View;
use soft\widget\adminlte3\InfoBoxWidget;

/* @var $this View */
/* @var $allClients Client[] */

$accountsSum = intval(Account::find()->sum('sum'));
$accountsDollar = intval(Account::find()->sum('dollar'));
$accountsBank = intval(Account::find()->sum('bank'));
$accountsTotal = intval(Account::find()->sum('total'));
$Skladresidualsum = ProductList::getResidualSum();
$clientsFinishAccount = 0;
foreach ($allClients as $client) {
    $clientsFinishAccount += $client->finishAccountSum;
}

$umumiy = $clientsFinishAccount + $accountsTotal + $Skladresidualsum;
?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-6">
        <?= InfoBoxWidget::widget([
            'text' => "Kassa sum",
            'textOptions' => ['class' => 'h5'],
            'number' => as_integer($accountsSum),
            'numberOptions' => ['class' => 'h4'],
            'iconBackground' => InfoBoxWidget::TYPE_SUCCESS,
            'icon' => 'money-bill-wave,fas',
            'iconOptions' => ['class' => 'd-none d-sm-block pt-2'],
        ]) ?>
    </div>
</div>