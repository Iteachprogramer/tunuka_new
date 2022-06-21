<?php

use common\models\DollarCourse;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'course',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_at',
        'format' => 'datetime',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_by',
        'value' => function (DollarCourse $model) {
            return $model->createdBy->username;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'updated_by',
        'value' => function (DollarCourse $model) {
            return $model->updatedBy->username;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{update} {view} {delete}',
        'vAlign' => 'middle',
//        'urlCreator' => function ($action, $model, $key, $index) {
//            return Url::to([$action, 'id' => $key]);
//        },
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
