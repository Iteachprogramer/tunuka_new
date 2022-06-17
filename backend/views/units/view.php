<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Units */
?>
<div class="units-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => $model->status ? '<span class="badge badge-success">Faol</span>' : '<span class="badge badge-danger">Faol emas</span>',
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy0->username,
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updatedBy0->username,
            ],
        ],
    ]) ?>

</div>
