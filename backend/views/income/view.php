<?php

use common\models\Income;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Income */
?>
<div class="income-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'product_type_id',
                'value' => function (Income $model) {
                    return $model->productType->product_name ?? '';
                }
            ],
            'cost',
            [
                'attribute' => 'provider_id',
                'value' => function (Income $model) {
                    return $model->provider->fulla_name ?? '';
                }
            ],
            [
                'attribute' => 'weight',
                'value' => function (Income $model) {
                    if ($model->unityType->id == 2) {
                        return $model->weight . ' ' . 'Tonna';
                    } else {
                        return $model->weight . ' ' . $model->unityType->name;

                    }
                }
            ],
            [
                'attribute' => 'length',
                'value' => function (Income $model) {
                    return $model->length . ' metr';
                }
            ],
            'cost_of_living',
            'dollar_course',
            [
                'attribute' => 'total',
                'value' => function (Income $model) {
                    return abs($model->total ). ' so\'m';
                    }
            ],
            [
                'attribute' => 'price_per_meter',
                'value' => function (Income $model) {
                    return $model->price_per_meter . ' so\'m';
                }
            ],
            'created_at:dateTime',
            'updated_at:dateTime',
            [
                'attribute' => 'created_by',
                'value' => function (Income $model) {
                    return $model->createdBy->username;
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function (Income $model) {
                    return $model->updatedBy->username;
                }
            ],
            'date',
        ],
    ]) ?>

</div>
