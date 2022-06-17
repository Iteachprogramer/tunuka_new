<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OutcomeItem */
?>
<div class="outcome-item-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'income_id',
            'outcome_id',
            'outcome_size',
            'residue_size',
        ],
    ]) ?>

</div>
