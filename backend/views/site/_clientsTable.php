<?php

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 02.07.2021, 15:22
 */

/* @var $this \yii\web\View */
/* @var $clientsList \backend\models\Client[] */

$count = count($clientsList);

$clients1 = [];
$clients2 = [];
$clients3 = [];

if ($count < 10) {
    $clients1 = $clientsList;
} elseif ($count < 30) {
    $singleColumnCount = (int)ceil($count / 2);
    $clients1 = array_slice($clientsList, 0, $singleColumnCount);
    $clients2 = array_slice($clientsList, $singleColumnCount);
} else {
    $singleColumnCount = (int)ceil($count / 3);
    $clients1 = array_slice($clientsList, 0, $singleColumnCount);
    $clients2 = array_slice($clientsList, $singleColumnCount, $singleColumnCount);
    $clients3 = array_slice($clientsList, $singleColumnCount * 2);
}

$index = 1;

$clients1Count = count($clients1);
$clients2Count = count($clients2);
$clientColumns = [$clients1, $clients2, $clients3];

?>

<div class="col-12">
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <?php for ($i = 0; $i <= $clients1Count; $i++): ?>
                <tr>
                    <?php if (isset($clients1[$i])): ?>
                        <?php $client = $clients1[$i] ?>
                        <th class="serial-column-cell"><?= $i + 1 ?></th>
                        <td class="table-<?= $client['bsClass'] ?>"><?= a($client['name'], ['client/view', 'id' => $client['id']]) ?></td>
                        <td class="table-<?= $client['bsClass'] ?>"><?= as_integer($client['finishAccount']) ?></td>
                    <?php endif; ?>
                    <?php if (isset($clients2[$i])): ?>
                        <?php $client = $clients2[$i] ?>
                        <th class="serial-column-cell"><?= $i + 1 + $clients1Count ?></th>
                        <td class="table-<?= $client['bsClass'] ?>"><?= a($client['name'], ['client/view', 'id' => $client['id']]) ?></td>
                        <td class="table-<?= $client['bsClass'] ?>"><?= as_integer($client['finishAccount']) ?></td>
                    <?php endif; ?>
                    <?php if (isset($clients3[$i])): ?>
                        <?php $client = $clients3[$i] ?>
                        <th class="serial-column-cell"><?= $i + 1 + $clients1Count + $clients2Count ?></th>
                        <td class="table-<?= $client['bsClass'] ?>"><?= a($client['name'], ['client/view', 'id' => $client['id']]) ?></td>
                        <td class="table-<?= $client['bsClass'] ?>"><?= as_integer($client['finishAccount']) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endfor; ?>
        </table>
    </div>
</div>