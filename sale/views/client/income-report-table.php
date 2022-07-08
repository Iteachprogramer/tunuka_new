<?php
/** @var TYPE_NAME $client */
/* @var $this \yii\web\View */
/* @var $model array|\common\models\Income[]|\yii\db\ActiveRecord[] */
?>
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
?>
<table cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td colspan="3" style="text-align: left; align-items: center;">Mijoz:</td>
        <td colspan="3" style="text-align: left; align-items: center;"><?= $client->fulla_name ?></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: left; align-items: center;">Xisobot chop etilgan sana</td>
        <td colspan="3"
            style="text-align: left; align-items: center;"><?= Yii::$app->formatter->asDate(time(), 'php:d.m.Y') ?></td>
    </tr>
</table>
<br>
<?php if ($model): ?>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: left; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">
        <tr>
            <td colspan="6" style="vertical-align: middle; text-align: center"> Rulonlar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: left;align-items: center">Rulon nomi</td>
            <td style="text-align: left;align-items: center">Sana</td>
            <td style="text-align: left;align-items: center">Narxi</td>
            <td style="text-align: left;align-items: center">Og'irligi</td>
            <td style="text-align: left;align-items: center">Umumiy summa</td>
        </tr>
        <?php
        $rulon_weight = 0;
        $rulon_summa = 0;
        ?>
        <?php foreach ($model

        as $key => $item): ?>
        <tr>
            <td align="left"><?= $key + 1 ?></td>
            <td><?= $item->productType->product_name ?></td>
            <td><?= Yii::$app->formatter->asDate($item->date, 'php:d.m.Y') ?></td>
            <td><?= as_dollar($item->cost) ?></td>
            <td><?= number_format($item->weight, 3) . ' tona' ?></td>
            <td><?= number_format($item->total, 3) ?></td>
            <?php endforeach; ?>
            <?php
            $rulon_weight += $item->weight;
            $rulon_summa += $item->total;

            ?>
        <tr>
            <td>Jami</td>
            <td style="text-align: left;align-items: center"></td>
            <td style="text-align: left;align-items: center"></td>
            <td style="text-align: left;align-items: center"></td>
            <td style="text-align: left;align-items: center"><?= number_format($rulon_weight, 3) . ' tona' ?></td>
            <td style="text-align: left;align-items: center"><?= number_format($rulon_summa, 3) ?></td>
        </tr>
    </table>
<?php endif; ?>
<?php if ($aksessuars): ?>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: left; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">
        <tr>
            <td colspan="6" style="vertical-align: middle; text-align: center"> Aksessuar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: left;align-items: center">Aksessuar nomi</td>
            <td style="text-align: left;align-items: center">Sana</td>
            <td style="text-align: left;align-items: center">Narxi</td>
            <td style="text-align: left;align-items: center">Miqdori</td>
            <td style="text-align: left;align-items: center">Umumiy summa</td>
        </tr>
        <?php
        $aksessuar_summa = 0;
        ?>
        <?php foreach ($aksessuars

        as $key => $aksessuar): ?>
        <?php
        $aksessuar_summa += $aksessuar->total;
        ?>
        <tr>
            <td align="left"><?= $key +1 ?></td>
            <td><?= $aksessuar->productType->product_name ?></td>
            <td><?= Yii::$app->formatter->asDate($aksessuar->date, 'php:d.m.Y') ?></td>
            <td><?= as_dollar($aksessuar->cost) ?></td>
            <td><?= number_format($aksessuar->weight, 3) . ' ' . $aksessuar->unityType->name ?></td>
            <td><?= number_format($aksessuar->total, 3) ?></td>
            <?php endforeach; ?>
        <tr>
            <td>Jami</td>
            <td style="text-align: left;align-items: center"></td>
            <td style="text-align: left;align-items: center"></td>
            <td style="text-align: left;align-items: center"></td>
            <td style="text-align: left;align-items: center"></td>
            <td style="text-align: left;align-items: center"><?= number_format($aksessuar_summa, 3) ?></td>
        </tr>
    </table>

<?php endif; ?>
<br>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td colspan="5" style="vertical-align: middle; text-align: center">Taminotchi bilan pul oldi berdi</td>
    </tr>
    <tr>
        <td>№</td>
        <td style="text-align: left;align-items: center">Sana</td>
        <td style="text-align: left;align-items: center">Sum</td>
        <td style="text-align: left;align-items: center">Bank</td>
        <td style="text-align: left;align-items: center">Dollar</td>
    </tr>
    <?php
    if ($date) {
        $dates = explode(' - ', $date, 2);
        if (count($dates) == 2) {
            $begin = strtotime($dates[0]);
            $end = strtotime('+1 day', strtotime($dates[1]));
            $accounts = Account::find()
                ->andWhere(['client_id' => $client->id])
                ->andFilterWhere(['>=', 'account.date', $begin])
                ->andFilterWhere(['<', 'account.date', $end])
                ->all();
        }
    } else {
        $accounts = Account::find()
            ->andWhere(['client_id' => $client->id])
            ->all();
    }
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
            <td style="text-align: left;align-items: center"><?= number_format($account->dollar, 3) ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td>Jami</td>
        <td align="left"><?= $account_sum ?></td>
        <td align="left"><?= $account_bank_sum ?></td>
        <td align="left"><?= number_format($account_dollar_sum, 3) ?></td>
</table>

