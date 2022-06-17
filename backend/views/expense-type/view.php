<?php


/* @var $this yii\web\View */

/* @var $model common\models\ExpenseType */

use soft\widget\bs4\DetailView;

?>
<div class="expense-type-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->status == \common\models\ExpenseType::STATUS_ACTIVE ? '<span class="badge badge-success">Faol</span>' : '<span class="badge badge-danger">Faol emas</span>';
                }

            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return $model->createdBy->username;
                }

            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    return $model->updatedBy->username;
                }

            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
