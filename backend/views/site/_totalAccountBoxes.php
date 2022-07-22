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

$accountsSum = intval(Account::find()->andWhere(['status'=>Account::STATUS_ACTIVE])->sum('sum'));
$accountsDollar = intval(Account::find()->andWhere(['status'=>Account::STATUS_ACTIVE])->sum('dollar'));
$accountsBank = intval(Account::find()->andWhere(['status'=>Account::STATUS_ACTIVE])->sum('bank'));
$accountsTotal = intval(Account::find()->andWhere(['status'=>Account::STATUS_ACTIVE])->sum('total'));
$Skladresidualsum = ProductList::getResidualSum();
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
    <div class="col-md-4 col-sm-6 col-6">
        <?= InfoBoxWidget::widget([
            'text' => "Kassa dollar",
            'textOptions' => ['class' => 'h5'],
            'number' => as_integer($accountsDollar),
            'numberOptions' => ['class' => 'h4'],
            'iconBackground' => InfoBoxWidget::TYPE_INFO,
            'icon' => 'dollar-sign,fas',
            'iconOptions' => ['class' => 'd-none d-sm-block pt-2'],
        ]) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-6">
        <?= InfoBoxWidget::widget([
            'text' => "Bank",
            'textOptions' => ['class' => 'h5'],
            'number' => as_integer($accountsBank),
            'numberOptions' => ['class' => 'h4'],
            'iconBackground' => InfoBoxWidget::TYPE_WARNING,
            'icon' => 'university,fas',
            'iconOptions' => ['class' => 'd-none d-sm-block pt-2'],
        ]) ?>
    </div>
</div>