<?php
/** @var OutcomeGroup $model */

use common\models\Outcome;
use common\models\OutcomeGroup;
use common\models\PrintSetting;
use common\models\ProductList;

$rulons =
    Outcome::find()
        ->select('product_type_id')
        ->andWhere(['group_id' => $model->id])
        ->andWhere(['type_id' => ProductList::TYPE_RULON])
        ->groupBy('product_type_id')
        ->all();
$aksessuars =
    Outcome::find()
        ->andWhere(['group_id' => $model->id])
        ->andWhere(['type_id' => ProductList::TYPE_AKSESSUAR])
        ->all();
$products =
    Outcome::find()
        ->andWhere(['group_id' => $model->id])
        ->andWhere(['type_id' => ProductList::TYPE_PRODUCT])
        ->all();
$client_sum = Outcome::find()
    ->andWhere(['group_id' => $model->id])
    ->sum('total');
?>
<style>
    .last {
        border-bottom: 1px dashed black;
    }
    .check-list table tr td {
        font-size: 30px;
    }
    .head-title{
        font-size: 26px;
    }
    .check-list table tr th {
        font-size: 30px;
    }

    .border-solid {
        border: 1px dashed black;
        padding: 8px;
    }

    .margin {
        padding-top: 10px;
    }
</style>
<?php
$print = PrintSetting::find()->one();
?>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<div class="check-list"
     style="border: 1px dashed black; display: inline-block; padding: 5px;width: <?= $print->width . 'px' ?>; max-width: <?= $print->width . 'px' ?>">
    <table style="width: 100%;">
        <tr>
            <td colspan="5" align="center"><img
                        src="<?= 'http://' . Yii::$app->request->hostName . '/frontend/web/98.png' ?>"
                        style="width: 90%;height: 60px; object-fit: cover"></td>
        </tr>
        <tr>
            <th colspan="2" style="font-size: 20px;">AS-PROFILE</th>
        </tr>
        <tr>
            <td align="center" colspan="2" style="font-size: 35px;">Tel:<span style="font-weight: bold">55 500 18 18</span></td>
        </tr>
        <tr>
            <td align="center" colspan="2" style="font-size: 35px;">Buyurtma nomeri:<span style="font-weight: bold"><?= $model->order_number ?></span></td>
        </tr>
        <tr>
            <td class="head-title"> Sanasi va vaqti</td>
            <th align="right" class="head-title"><?=
                Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i:s') ?></th>
        </tr>
        <tr  >
            <td class="head-title">Mijoz</td>
            <th align="right" class="head-title"><?= $model->client->fulla_name ?></th>
        </tr>
        <tr>
            <td class="head-title">Sotuvchi</td>
            <th align="right" class="head-title"><?= $model->createdBy->firstname . ' ' . $model->createdBy->lastname ?></th>
        </tr>
        <tr>
            <td class="head-title">Telefon nomeri</td>
            <th align="right" class="head-title">+<?= $model->client->phone ?></th>
        </tr>

        <tr>
            <td class="head-title">Manzil</td>
            <th align="right" class="head-title"><?= $model->where ?></th>
        </tr>

    </table>
    <?php if ($rulons): ?>
        <table style="width: 100%">
            <tr>
                <th style="border-bottom: 2px dotted black;">No</th>
                <th style="border-bottom: 2px dotted black;">olchami</th>
                <th style="border-bottom: 2px dotted black;">soni</th>
                <th style="border-bottom: 2px dotted black;">metri</th>
                <th style="border-bottom: 2px dotted black;" colspan="2">narxi</th>
            </tr>
            <?php foreach ($rulons as $rulon): ?>
                <?php
                $rulon_sum = 0;
                $rulon_sum_metr = 0;
                $items = Outcome::getItems($rulon->product_type_id, $model->id);
                ?>
                <tr align="center">
                    <th colspan="5"><?= $rulon->productType->product_name ?></th>
                </tr>
                <?php foreach ($items as $key => $item): ?>
                    <?php
                    $rulon_sum += $item->total;
                    $rulon_sum_metr += $item->total_size;
                    ?>
                    <tr>
                        <td style="border-bottom: 1px dotted black;"><?= $key + 1 ?></td>
                        <td style="border-bottom: 1px dotted black;" align="left" ><?= $item->size ?></td>
                        <td style="border-bottom: 1px dotted black;" align="left" ><?= $item->count ?></td>
                        <td style="border-bottom: 1px dotted black;" align="left" ><?= $item->total_size ?></td>
                        <td style="border-bottom: 1px dotted black;" align="right" colspan="2"> <?= as_integer($item->cost) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>jami</td>
                    <td></td>
                    <td></td>
                    <td ><?= $rulon_sum_metr ?></td>
                    <td align="right" colspan="2"><?= as_integer($rulon_sum) ?></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <?php if ($products): ?>
        <table style="width: 100%">
            <tr>
                <th align="center" colspan="5">Mahsulotlar</th>
            </tr>
            <tr>
                <th style="border-bottom: 1px dotted black;">No</th>
                <th style="border-bottom: 1px dotted black;">mahsulot</th>
                <th style="border-bottom: 1px dotted black;">metr</th>
                <th style="border-bottom: 1px dotted black;">narxi</th>
                <th style="border-bottom: 1px dotted black;">summa</th>
            </tr>
            <?php foreach ($products as $key => $product): ?>
                <?php
                $product_sum += $product->total;
                ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td align="left" ><?= $product->productType->product_name ?></td>
                    <td align="left" ><?= $product->total_size ?></td>
                    <td align="left"><?= $product->cost ?></td>
                    <td align="right"><?= as_integer($product->total) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="last" colspan="5"></td>
            </tr>
            <tr>
                <td colspan="3">jami</td>
                <td align="right"  colspan="2"><?= as_integer($product_sum) ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <?php if ($aksessuars): ?>
        <table style="width: 100%">
            <tr>
                <th align="center" colspan="5">Aksesuarlari</th>
            </tr>
            <tr>
                <th style="border-bottom: 1px dotted black;">No</th>
                <th style="border-bottom: 1px dotted black;">mahsulot</th>
                <th style="border-bottom: 1px dotted black;">soni</th>
                <th style="border-bottom: 1px dotted black;">narxi</th>
                <th style="border-bottom: 1px dotted black;">summa</th>
            </tr>
            <?php foreach ($aksessuars as $key => $aksessuar): ?>
                <?php
                $aksessuar_sum += $aksessuar->total;
                ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td align="left" ><?= $aksessuar->productType->product_name ?></td>
                    <td align="left" ><?= $aksessuar->count ?></td>
                    <td align="left" ><?= $aksessuar->cost ?></td>
                    <td align="right"><?= as_integer($aksessuar->total) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="last" colspan="5"></td>
            </tr>
            <tr>
                <td colspan="3">jami</td>
                <td align="right" colspan="2"><?= as_integer($aksessuar_sum) ?></td>
            </tr>
        </table>
    <?php endif; ?>
    <table style="width: 100%">
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td>Jami summa</td>
            <td align="right"><?= as_integer($client_sum) ?></td>
        </tr>
        <tr>
            <td>Chegirma</td>
            <td align="right"><?= as_integer($model->discount) ?></td>
        </tr>
        <tr>
            <td>To'lanadigan summa</td>
            <td align="right"><?= as_integer($model->outcomeSum -$model->discount) ?></td>
        </tr>
        <tr>
            <td>Mijoz qoldig'i</td>
            <td align="right"><?= as_integer($model->client->finishAccountSum) ?></td>
        </tr>
        <tr>
            <td>To'landi</td>
            <td width="30%" class="last" align="right"></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr align="center">
            <th class="border-solid" colspan="2">Xaridingiz uchun rahmat</th>
        </tr>
    </table>
</div>

