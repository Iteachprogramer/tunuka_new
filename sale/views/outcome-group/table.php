<?php

use common\models\Account;
use common\models\Client;
use common\models\Outcome;
use common\models\OutcomeGroup;
use common\models\ProductList;

/** @var Client $client_id */
/** @var Account $date */
/* @var $this \yii\web\View */
/* @var $groups array */
$sum_group = 0;
foreach ($groups as $group) {
    $sum_group += Outcome::find()->where(['group_id' => $group->id])->sum('total') - $group->discount;
}
if ($date) {
    $dates = explode(' - ', $date, 2);
    if (count($dates) == 2) {
        $begin = strtotime($dates[0]);
        $end = strtotime('+1 day', strtotime($dates[1]));
        $accounts = Account::find()
            ->andWhere(['client_id' => $client_id])
            ->andFilterWhere(['>=', 'account.date', $begin])
            ->andFilterWhere(['<', 'account.date', $end])
            ->all();
    }
} else {
    $accounts = Account::find()
        ->andWhere(['client_id' => $client_id])
        ->all();
}
$finish_account_sum= 0;
$finish_account_dollar= 0;
foreach ($accounts as $account) {
    $finish_account_sum += $account->sum;
}
$finish_sum = $sum_group - $finish_account_sum;
?>
<table cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td colspan="4" style="text-align: left; align-items: center;">Mijoz:</td>
        <td colspan="4" style="text-align: left; align-items: center;"><?= $groups[0]->client->fulla_name ?></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: left; align-items: center;">Xisobot chop etilgan sana</td>
        <td colspan="4"
            style="text-align: left; align-items: center;"><?= Yii::$app->formatter->asDate(time(), 'php:d.m.Y') ?></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: left; align-items: center;">Xisobot kitob</td>
        <td colspan="4"
            style="text-align: left; align-items: center;"><?= as_integer($finish_sum) ?></td>
    </tr>
</table>
<br>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td colspan="8" style="vertical-align: middle; text-align: center"> Rulonlar</td>
    </tr>
    <tr>
        <td>№</td>
        <td style="text-align: left;align-items: center">Tovar nomi</td>
        <td style="text-align: left;align-items: center">Sana</td>
        <td style="text-align: left;align-items: center">O'lchami</td>
        <td style="text-align: left;align-items: center">soni</td>
        <td style="text-align: left;align-items: center">Umumiy metr</td>
        <td style="text-align: left;align-items: center">Narxi</td>
        <td style="text-align: left;align-items: center">Umumiy summa</td>
    </tr>
    <?php
    $rulon_sum = 0;
    $rulon_length = 0;
    ?>
    <?php foreach ($groups as $group): ?>
        <?php
        $outcomes = Outcome::find()->andWhere(['group_id' => $group->id])->andWhere(['type_id' => ProductList::TYPE_RULON])->all();
        ?>
        <?php if ($outcomes): ?>
            <?php foreach ($outcomes as $key => $outcome): ?>
                <?php
                $rulon_sum += $outcome->total;
                $rulon_length += $outcome->total_size;
                ?>
                <tr>
                    <td style="text-align: left;align-items: center"><?= $key + 1 ?></td>
                    <td style="text-align: left;align-items: center"><?= $outcome->productType->product_name ?></td>
                    <td style="text-align: left;align-items: center"><?= Yii::$app->formatter->asDatetime($group->date, 'php:d.m.Y H:i:s') ?></td>
                    <td style="text-align: left;align-items: center"><?= number_format($outcome->size, 2) . ' metr' ?></td>
                    <td style="text-align: left;align-items: center"><?= $outcome->count ?></td>
                    <td style="text-align: left;align-items: center"><?= number_format($outcome->total_size, 2) . ' metr' ?></td>
                    <td style="text-align: left;align-items: center"><?= as_integer($outcome->cost) ?></td>
                    <td style="text-align: left;align-items: center"><?= as_integer($outcome->total) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;align-items: center"><?= number_format($rulon_length, 2) . ' metr ' ?></td>
        <td></td>
        <td style="text-align: left;align-items: center"><?= as_integer($rulon_sum) ?></td>
    </tr>
</table>
<br>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td colspan="6" style="vertical-align: middle; text-align: center">Mahsulotlar</td>
    </tr>
    <tr>
        <td>№</td>
        <td style="text-align: left;align-items: center">Mahsulot nomi</td>
        <td style="text-align: left;align-items: center">Sana</td>
        <td style="text-align: left;align-items: center">O'lchami</td>
        <td style="text-align: left;align-items: center">Narxi</td>
        <td style="text-align: left;align-items: center">Umumiy summa</td>
    </tr>
    <?php
    $outcomes_product_sum = 0;
    $outcome_products_total_size = 0;
    ?>
    <?php foreach ($groups as $group): ?>
        <?php $outcome_products = Outcome::find()->andWhere(['group_id' => $group->id])->andWhere(['type_id' => ProductList::TYPE_PRODUCT])->with(['productType', 'unity'])->all() ?>
        <?php if ($outcome_products): ?>
            <?php foreach ($outcome_products as $key => $outcome_product): ?>
                <?php
                $outcomes_product_sum += $outcome_product->total;
                $outcome_products_total_size += $outcome_product->total_size;
                ?>
                <tr>
                    <td style="text-align: left;align-items: center"><?= $key + 1 ?></td>
                    <td style="text-align: left;align-items: center"><?= $outcome_product->productType->product_name ?></td>
                    <td style="text-align: left;align-items: center"><?= Yii::$app->formatter->asDatetime($group->date, 'php:d.m.Y H:i:s') ?></td>
                    <td style="text-align: left;align-items: center"><?= number_format($outcome_product->total_size, 2) . ' ' . $outcome_product->unity->name ?></td>
                    <td style="text-align: left;align-items: center"><?= as_integer($outcome_product->cost) ?></td>
                    <td style="text-align: left;align-items: center"><?= as_integer($outcome_product->total) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;align-items: center"><?= number_format($outcome_products_total_size, 2) . ' ' . $outcome_product->unity->name ?></td>
        <td></td>
        <td style="text-align: left;align-items: center"><?= as_integer($outcomes_product_sum) ?></td>
    </tr>
</table>
<br>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td colspan="6" style="vertical-align: middle; text-align: center">Aksessuar</td>
    </tr>
    <tr>
        <td>№</td>
        <td style="text-align: left;align-items: center">Mahsulot nomi</td>
        <td style="text-align: left;align-items: center">Sana</td>
        <td style="text-align: left;align-items: center">Miqdori</td>
        <td style="text-align: left;align-items: center">Narxi</td>
        <td style="text-align: left;align-items: center">Umumiy summa</td>
    </tr>
    <?php
    $outcome_aksessuar_sum = 0;
    ?>
    <?php foreach ($groups as $group): ?>
        <?php $outcome_aksessuars = Outcome::find()->andWhere(['group_id' => $group->id])->andWhere(['type_id' => ProductList::TYPE_AKSESSUAR])->with('productType', 'unity')->all() ?>
        <?php if ($outcome_aksessuars): ?>
            <?php foreach ($outcome_aksessuars as $key => $outcome_aksessuar): ?>
                <?php
                $outcome_aksessuar_sum += $outcome_aksessuar->total;
                ?>
                <tr>
                    <td style="text-align: left;align-items: center"><?= $key + 1 ?></td>
                    <td style="text-align: left;align-items: center"><?= $outcome_aksessuar->productType->product_name ?></td>
                    <td style="text-align: left;align-items: center"><?= Yii::$app->formatter->asDatetime($group->date, 'php:d.m.Y H:i:s') ?></td>
                    <td style="text-align: left;align-items: center"><?= number_format($outcome_aksessuar->count, 2) . ' ' . $outcome_aksessuar->unity->name ?></td>
                    <td style="text-align: left;align-items: center"><?= as_integer($outcome_aksessuar->cost) ?></td>
                    <td style="text-align: left;align-items: center"><?= as_integer($outcome_aksessuar->total) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: left;align-items: center"><?= as_integer($outcome_aksessuar_sum) ?></td>
</table>
<br>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td colspan="5" style="vertical-align: middle; text-align: center">Mijozdan olingan pullar</td>
    </tr>
    <tr>
        <td>№</td>
        <td style="text-align: left;align-items: center">Sana</td>
        <td style="text-align: left;align-items: center">Sum</td>
        <td style="text-align: left;align-items: center">Bank</td>
        <td style="text-align: left;align-items: center">Dollar</td>
    </tr>
    <?php
    $account_sum = 0;
    $account_dollar_sum = 0;
    $account_bank_sum = 0;
    ?>
    <?php foreach ($accounts as $key => $account): ?>
        <?php
        $account_sum += $account->sum;
        $account_dollar_sum += $account->dollar;
        $account_bank_sum += $account->bank;
        ?>
        <tr>
            <td style="text-align: left;align-items: center"><?= $key + 1 ?></td>
            <td style="text-align: left;align-items: center"><?= Yii::$app->formatter->asDatetime($account->date, 'php:d.m.Y') ?></td>
            <td style="text-align: left;align-items: center"><?= as_integer($account->sum) ?></td>
            <td style="text-align: left;align-items: center"><?= as_integer($account->bank) ?></td>
            <td style="text-align: left;align-items: center"><?= floatval($account->dollar) ?></td>
        </tr>
    <?php endforeach; ?>

    <tr>
        <td></td>
        <td>Jami</td>
        <td align="left"><?= $account_sum ?></td>
        <td align="left"><?= $account_bank_sum ?></td>
        <td align="left"><?= $account_dollar_sum ?></td>
</table>
