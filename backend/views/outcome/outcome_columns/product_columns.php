<?php

use common\models\Client;
use common\models\Outcome;
use common\models\ProductList;
use soft\grid\GridView;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'client_id',
//        'filterType' => GridView::FILTER_SELECT2,
//        'filterWidgetOptions' => [
//            'data' => Client::getClient(),
//            'options' => [
//                'placeholder' => 'Klientni tanlang...',
//            ],
//            'pluginOptions' => [
//                'allowClear' => true,
//            ]
//        ],
//        'value' => function (Outcome $model) {
//            return $model->client->fulla_name;
//        },
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'Mahsulot',

        'value' => function (Outcome $model) {
            return $model->productType->product_name;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cost',
        'format' => 'integer',
        'width' => '150px',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'size',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'count',
//        'value' => function (Outcome $model) {
//            if ($model->unit_id == 2) {
//                return $model->count ;
//            } else {
//                return $model->count . ' ' . $model->unity->name;
//            }
//        },
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'total_size',
        'value' => function(Outcome $model){
        return $model->total_size . ' ' . $model->unity->name;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'total',
        'format' => 'integer',
        'pageSummary' => true,
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'unit_id',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'discount',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
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
