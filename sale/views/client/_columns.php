<?php

use common\models\Client;
use common\models\ProductList;
use soft\helpers\Html;
use yii\helpers\Url;

return [
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'fulla_name',
        'format' => 'raw',
        'value' => function ($model)
        {
            return Html::a($model->fulla_name, Url::to(['client/view', 'id' => $model->id]),['data-pjax' => 0]);
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'phone',

    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'residue',
        'format' => ['decimal',0],
        'value' => function(Client $model)
        {
            return$model->finishAccountSum;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'residue_dollar',
        'format' => ['decimal',0],
        'value' => function(Client $model)
        {
            return$model->finishAccountSumDollar;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'client_type_id',
        'format' => 'raw',
        'filter' => Client::clientTypes(),
        'value' => function (Client $model) {

          if ($model->client_type_id == Client::CLIENT_TYPE_PROVIDER){
              return "<span class='badge badge-success'>Taminotchi</span>";
          }
          else{
              return  "<span class='badge badge-warning'>Mijoz</span>";
          }
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{update}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false,// for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'],
    ],

];
