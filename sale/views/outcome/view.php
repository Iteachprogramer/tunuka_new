<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Outcome */
?>
<div class="outcome-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id',
            'product_type_id',
            'size',
            'count',
            'total_size',
            'total',
            'unit_id',
            'discount',
        ],
    ]) ?>

</div>
