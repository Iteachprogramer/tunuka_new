<?php

use common\models\Client;
use common\models\Income;
use common\models\ProductList;
use soft\grid\GridView;
use yii\helpers\Url;

return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'product_type_id',
        'format' => 'raw',
        'width' => '260px',
        'value' => function(Income $model){
            return $model->productType->product_name;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cost',
        'format' => 'decimal',

    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'weight',
        'value' => function (Income $model) {
            if ($model->unityType->id == 2) {
                return $model->weight . ' tona';
            } else {
                return $model->weight . ' ' . $model->unityType->name;
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'total',
        'format' => 'decimal',
        'pageSummary' => true,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cost_of_living',
        'format' => 'integer',
        'pageSummary' => true,
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action.'-'.'income','id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Are you sure?',
            'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
