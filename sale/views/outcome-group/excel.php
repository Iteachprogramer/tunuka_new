<?php
/** @var Out $model */

use common\models\Outcome;
use common\models\ProductList;

?>
    <style>
        table tr td {
            boder: 1px dashed black;
        }
    </style>
<table  cellspacing="0" cellpadding="3"
        style="text-align: center; align-items: center;display: none;width: 100%!important;"
        class="table table-bordered table-striped">
    <tr>
        <td></td>
        <td></td>
        <td>Xisobot sanasi:</td>
        <td><?=Yii::$app->formatter->asDate(time(),'php:d.m.Y')?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Mijoz nomi:</td>
        <td><?=$model->client->fulla_name?></td>
        <td></td>
    </tr>
</table>
<?php
$outcomes = Outcome::find()->where(['group_id' => $model->id])->andWhere(['type_id' => ProductList::TYPE_RULON])->all();
?>
<?php if ($outcomes): ?>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: center; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">
        <tr>
            <td colspan="7" style="vertical-align: middle; text-align: center"> Rulonlar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: center;align-items: center">Tovar nomi</td>
            <td style="text-align: center;align-items: center">O'lchami</td>
            <td style="text-align: center;align-items: center">soni</td>
            <td style="text-align: center;align-items: center">Umumiy metr</td>
            <td style="text-align: center;align-items: center">Narxi</td>
            <td style="text-align: center;align-items: center">Umumiy summa</td>
        </tr>
        <?php foreach ($outcomes as $key => $outcome): ?>
            <tr>
                <td style="text-align: center;align-items: center"><?= $key + 1 ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome->productType->product_name ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome->size ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome->count ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome->total_size ?></td>
                <td style="text-align: center;align-items: center"><?= as_integer($outcome->cost) ?></td>
                <td style="text-align: center;align-items: center"><?= as_integer($outcome->total) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;align-items: center"> <?= Outcome::getSumOutcomeTotalSize(ProductList::TYPE_RULON,$model->id)?></td>
            <td ></td>
            <td  style="text-align: center;align-items: center" ><?= as_integer(Outcome::getSumOutcome(ProductList::TYPE_RULON,$model->id))?></td>
        </tr>
    </table>
<?php endif; ?>
    <br>
<?php
$outcome_products = Outcome::find()->where(['group_id' => $model->id])->andWhere(['type_id' => ProductList::TYPE_PRODUCT])->all();
?>
<?php if ($outcome_products): ?>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: center; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">

        <tr>
            <td colspan="5" style="text-align: center;align-items: center">Mahsulotlar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: center;align-items: center">Tovar nomi</td>
            <td style="text-align: center;align-items: center">Umumiy metr</td>
            <td style="text-align: center;align-items: center">Narxi</td>
            <td style="text-align: center;align-items: center">Umumiy summa</td>
        </tr>

        <?php foreach ($outcome_products as $key => $outcome_product): ?>
            <tr>
                <td style="text-align: center;align-items: center"><?= $key + 1 ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome_product->productType->product_name ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome_product->total_size ?></td>
                <td style="text-align: center;align-items: center"><?= as_integer($outcome_product->cost) ?></td>
                <td style="text-align: center;align-items: center"><?= as_integer($outcome_product->total) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: center;align-items: center"> <?= Outcome::getSumOutcomeTotalSize(ProductList::TYPE_PRODUCT,$model->id)?></td>
            <td ></td>
            <td  style="text-align: center;align-items: center" ><?= as_integer(Outcome::getSumOutcome(ProductList::TYPE_PRODUCT,$model->id))?></td>
        </tr>
    </table>
<?php endif; ?>
<?php
$outcome_aksessuars = Outcome::find()->where(['group_id' => $model->id])->andWhere(['type_id' => ProductList::TYPE_AKSESSUAR])->all();
?>
    <br>
<?php if ($outcome_aksessuars): ?>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: center; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">
        <tr>
            <td colspan="5" style="text-align: center;align-items: center">Aksessuarlar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: center;align-items: center">Tovar nomi</td>
            <td style="text-align: center;align-items: center">Umumiy metr</td>
            <td style="text-align: center;align-items: center">Narxi</td>
            <td style="text-align: center;align-items: center">Umumiy summa</td>
        </tr>


        <?php foreach ($outcome_aksessuars as $key => $outcome_aksessuar): ?>
            <tr>
                <td style="text-align: center;align-items: center"><?= $key + 1 ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome_aksessuar->productType->product_name ?></td>
                <td style="text-align: center;align-items: center"><?= $outcome_aksessuar->count ?></td>
                <td style="text-align: center;align-items: center"><?= as_integer($outcome_aksessuar->cost) ?></td>
                <td style="text-align: center;align-items: center"><?= as_integer($outcome_aksessuar->total) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td ></td>
            <td  style="text-align: center;align-items: center" ><?= as_integer(Outcome::getSumOutcome(ProductList::TYPE_AKSESSUAR,$model->id))?></td>
        </tr>
    </table>
<?php endif; ?>