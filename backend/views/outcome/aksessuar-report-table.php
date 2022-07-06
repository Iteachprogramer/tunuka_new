<?php



/* @var $this \yii\web\View */
/* @var $model array|\common\models\Outcome[]|\yii\db\ActiveRecord[] */
?>
<table border="1" cellspacing="0" cellpadding="3"
       style="text-align: left; align-items: center;display: none;width: 100%!important;"
       class="table table-bordered table-striped">
    <tr>
        <td style="vertical-align: middle; text-align: left">Aksessuar</td>
        <td style="vertical-align: middle; text-align: left">Sana</td>
        <td style="vertical-align: middle; text-align: left">Narx</td>
        <td style="vertical-align: middle; text-align: left">Miqdori</td>
        <td style="vertical-align: middle; text-align: left">Umumiy summa</td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <?php
    $aksessuars_summa = 0;
    $aksessuars = $model;
    ?>
    <?php foreach ($aksessuars as $aksessuar): ?>
        <tr>
            <td style="vertical-align: middle; text-align: left"><?= $aksessuar->productType->product_name ?></td>
            <td style="vertical-align: middle; text-align: left"><?= Yii::$app->formatter->asDatetime($aksessuar->created_at, 'php:d.m.Y H:i:s') ?></td>
            <td style="vertical-align: middle; text-align: left"><?= as_integer($aksessuar->cost) ?></td>
            <td style="vertical-align: middle; text-align: left"><?= $aksessuar->count . ' ' . $aksessuar->unity->name ?></td>
            <td style="vertical-align: middle; text-align: left"><?= as_integer($aksessuar->total) ?></td>
        </tr>
        <?php
        $aksessuars_summa += $aksessuar->total;
        ?>
    <?php endforeach; ?>
    <tr>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"></td>
        <td style="vertical-align: middle; text-align: left"><?=as_integer($aksessuars_summa) ?></td>
    </tr>
</table>

