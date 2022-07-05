<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OutcomeGroup */
?>
<div class="outcome-group-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id',
            'date',
            'status',
            'discount',
            'total',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
