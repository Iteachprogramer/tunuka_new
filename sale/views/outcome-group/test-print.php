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

    .border-solid {
        border: 1px dashed black;
        padding: 8px;
    }

    .margin {
        padding-top: 10px;
    }
</style>
<?php
$print= PrintSetting::find()->one();

?>
<div style="border: 1px dashed black; display: inline-block; padding: 5px;width: <?=$print->width.'px'?>">
    <table width="350">
        <tr>
            <th colspan="2">AS-PROFILE</th>
        </tr>
        <tr>
            <td align="center" colspan="2">Tel: 545646546/ 654564</td>
        </tr>
        <tr>
            <td>Sanasi va vaqti</td>
            <th align="right"><?=
                Yii::$app->formatter->asDatetime($model->date, 'dd.MM.yyyy H:i:s') ?></th>
        </tr>
        <tr>
            <td>Mijoz</td>
            <th align="right"><?= $model->client->fulla_name ?></th>
        </tr>
        <tr>
            <td>Telefon no'meri</td>
            <th align="right">+<?= $model->client->phone ?></th>
        </tr>
        <tr>
            <td>Buyurtma no'meri</td>
            <th align="right"><?= $model->id ?></th>
        </tr>
        <tr>
            <td>Manzil</td>
            <th align="right"><?= $model->where ?></th>
        </tr>

    </table>
    <?php if ($rulons): ?>
        <table width="350">
            <tr>
                <th style="border-bottom: 2px dotted black;">No</th>
                <th style="border-bottom: 2px dotted black;">olchami</th>
                <th style="border-bottom: 2px dotted black;">soni</th>
                <th style="border-bottom: 2px dotted black;">metri</th>
                <th style="border-bottom: 2px dotted black;">narxi</th>
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
                        <td style="border-bottom: 1px dotted black;" align="center"><?= $item->size ?></td>
                        <td style="border-bottom: 1px dotted black;" align="center"><?= $item->count ?></td>
                        <td style="border-bottom: 1px dotted black;" align="center"><?= $item->total_size ?></td>
                        <td style="border-bottom: 1px dotted black;" align="right"> <?= as_integer($item->cost) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>jami</td>
                    <td></td>
                    <td></td>
                    <td align="center"><?= $rulon_sum_metr ?></td>
                    <td align="right"><?= as_integer($rulon_sum) ?></td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <?php if ($aksessuars): ?>
        <table width="350">
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
                    <td><?= $aksessuar->productType->product_name ?></td>
                    <td><?= $aksessuar->count ?></td>
                    <td><?= $aksessuar->cost ?></td>
                    <td align="right"><?= as_integer($aksessuar->total) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="last" colspan="5"></td>
            </tr>
            <tr>
                <td colspan="4">jami</td>
                <th align="right"><?= as_integer($aksessuar_sum) ?></th>
            </tr>
        </table>
    <?php endif; ?>
    <?php if ($products): ?>
        <table width="350">
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
                    <td><?= $product->productType->product_name ?></td>
                    <td><?= $product->total_size ?></td>
                    <td><?= $product->cost ?></td>
                    <td align="right"><?= as_integer($product->total) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="last" colspan="5"></td>
            </tr>
            <tr>
                <td colspan="4">jami</td>
                <th align="right"><?= as_integer($product_sum) ?></th>
            </tr>
        </table>
    <?php endif; ?>
    <table width="350">
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
            <td align="right"><?= as_integer($model->total) ?></td>
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

