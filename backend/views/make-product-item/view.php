<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MakeProductItem */
?>
<div class="make-product-item-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'income_id',
            'make_id',
            'outcome_size',
            'residue_size',
        ],
    ]) ?>

</div>
