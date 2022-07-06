<?php


/* @var $this \yii\web\View */
/* @var $model array|\common\models\Outcome[]|\yii\db\ActiveRecord[] */
?>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: center; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td style="vertical-align: middle; text-align: left">Rulon</td>
        <td style="vertical-align: middle; text-align: left">Sana</td>
        <td style="vertical-align: middle; text-align: left">Narx</td>
        <td style="vertical-align: middle; text-align: left">O'lchami</td>
        <td style="vertical-align: middle; text-align: left">Miqdori</td>
        <td style="vertical-align: middle; text-align: left">Umumiy o'lcham</td>
        <td style="vertical-align: middle; text-align: left">Umumiy summa</td>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
    <?php
    $rulons_summa = 0;
    $rulons_total_size = 0;
    $rulons = $model;
    ?>
    <?php foreach ($rulons as $rulon): ?>
        <tr>
            <td style="vertical-align: middle; text-align: left"><?= $rulon->productType->product_name ?></td>
            <td style="vertical-align: middle; text-align: left"><?= Yii::$app->formatter->asDatetime($rulon->created_at, 'php:d.m.Y H:i:s') ?></td>
            <td style="vertical-align: middle; text-align: left"><?= $rulon->cost ?></td>
            <td style="vertical-align: middle; text-align: left"><?= $rulon->size . ' ' . $rulon->unity->name ?></td>
            <td style="vertical-align: middle; text-align: left"><?= $rulon->count ?></td>
            <td style="vertical-align: middle; text-align: left"><?= $rulon->total_size . ' ' . $rulon->unity->name ?></td>
            <td style="vertical-align: middle; text-align: left"><?= $rulon->total ?></td>
        </tr>
        <?php
        $rulons_summa += $rulon->total;
        $rulons_total_size += $rulon->total_size;
        ?>
    <?php endforeach; ?>
    <tr>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"><?= $rulons_total_size ?> metr</td>
        <td style="vertical-align: middle; text-align: left"><?= $rulons_summa ?></td>
    </tr>
</table>
