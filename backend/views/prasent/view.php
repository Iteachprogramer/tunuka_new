<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Prasent */
?>
<div class="prasent-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'prasent',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
