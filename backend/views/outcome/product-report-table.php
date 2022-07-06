<?php



/* @var $this \yii\web\View */
/* @var $model array|\common\models\Outcome[]|\yii\db\ActiveRecord[] */
?>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td style="vertical-align: middle; text-align: left">Mahsulot</td>
        <td style="vertical-align: middle; text-align: left">Sana</td>
        <td style="vertical-align: middle; text-align: left">Narx</td>
        <td style="vertical-align: middle; text-align: left">O'lchami</td>
        <td style="vertical-align: middle; text-align: left">Umumiy summa</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <?php
    $roducts_summa = 0;
    $roducts_total_size = 0;
    $roducts = $model;
    ?>
    <?php foreach ($roducts as $product): ?>
        <tr>
            <td style="vertical-align: middle; text-align: left"><?= $product->productType->product_name ?></td>
            <td style="vertical-align: middle; text-align: left"><?= Yii::$app->formatter->asDatetime($product->created_at, 'php:d.m.Y H:i:s') ?></td>
            <td style="vertical-align: middle; text-align: left"><?= as_integer($product->cost) ?></td>
            <td style="vertical-align: middle; text-align: left"><?= $product->total_size . ' ' . $product->unity->name ?></td>
            <td style="vertical-align: middle; text-align: left"><?= as_integer($product->total) ?></td>
        </tr>
        <?php
        $roducts_summa += $product->total;
        $roducts_total_size += $product->total_size;
        ?>
    <?php endforeach; ?>
    <tr>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>

        <td style="vertical-align: middle; text-align: left"><?= $roducts_total_size ?> metr</td>
        <td style="vertical-align: middle; text-align: left"><?= as_integer($roducts_summa) ?></td>
    </tr>
</table>

