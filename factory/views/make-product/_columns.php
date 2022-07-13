<?php

use common\models\Employees;
use common\models\MakeProduct;
use common\models\ProductList;
use common\models\Shapes;
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
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'employee_id',
        'width' => '120px',
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => Employees::getMap(),
            'options' => [
                'placeholder' => 'Mahsulotni tanlang...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
        'value' => function ($model) {
            return $model->employee->name;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'product_id',
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => ProductList::getRulon(),
            'options' => [
                'placeholder' => 'Mahsulotni tanlang...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
        'value' => function ($model) {
            return $model->product->product_name;
        },
    ],
    [
        'attribute' => 'date',
        'width' => '160px',
        'value' => function(MakeProduct $model){
            return Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y');
        },
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'model' => $searchModel,
            'convertFormat' => true,
            'presetDropdown' => true,
            'includeMonthsFilter' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'd.m.Y'
                ]
            ]
        ]

    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'size',
        'pageSummary' => true
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'produced_id',
        'width' => '60px',
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => ProductList::getProduct(),
            'options' => [
                'placeholder' => 'Mahsulotni tanlang...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
        'value' => function ($model) {
            return $model->produced->product_name;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'factory_size',
        'pageSummary' => true
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'total_expence',
        'pageSummary' => true
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{view} {delete}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false,// for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'],
    ],

];
