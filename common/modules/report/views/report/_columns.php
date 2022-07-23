<?php

use common\models\Employees;
use soft\grid\GridView;
use yii\helpers\Url;

return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'employee_id',
        'value' => function ($model) {
            return $model->employee->name;
        },
        'format' => 'raw',
        'width' => '250px',
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => Employees::getMap(),
            'options' => [
                'placeholder' => 'Hodimni tanlang...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'date',
        'value' => function ($model) {
            return Yii::$app->formatter->asDate($model->date);
        },

    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'work_time',
//    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'start_day',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'end_day',
//    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
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
