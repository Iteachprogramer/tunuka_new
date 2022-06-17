<?php


/* @var $this yii\web\View */

/* @var $model common\models\MakeProduct */

use common\models\MakeProduct;
use soft\widget\bs4\DetailView;

?>
<div class="make-product-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'employee_id',
                'value' => function ($model) {
                    return $model->employee->name;
                }
            ],
            [
                'attribute' => 'product_id',
                'value' => function ($model) {
                    return $model->product->product_name;
                }
            ],
            'size',
            [
                'attribute' => 'produced_id',
                'value' => function ($model) {
                    return $model->produced->product_name;
                }
            ],
//            'shape_id',
//            'type_id',
            [
                'attribute' => 'shape_id',
                'value' => function (MakeProduct $model) {
                    return $model->shape->name;
                }
            ],
            'created_at',
            'updated_at',
            [
                    'attribute'=>'created_by',
                    'value'=>function($model){
                        return $model->createdBy->username;
                    }
            ],
            [
                    'attribute'=>'updated_by',
                    'value'=>function($model){
                        return $model->updatedBy->username;
                    }
            ],
        ],
    ]) ?>

</div>
