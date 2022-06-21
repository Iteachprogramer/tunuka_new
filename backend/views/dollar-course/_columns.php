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
    'actionColumn' => [
        'width' => '130px',
        'viewOptions' => [
            'role' => 'modal-remote',
        ],
        'updateOptions' => [
            'role' => 'modal-remote',
        ],
    ],
];
