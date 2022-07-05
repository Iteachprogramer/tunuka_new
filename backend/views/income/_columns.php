<?php

use common\models\Client;
use common\models\Income;
use common\models\ProductList;
use soft\grid\GridView;
use soft\helpers\ArrayHelper;
use soft\helpers\Html;
use yii\helpers\Url;

return [
    [
        'attribute' => 'date',
        'width' => '160px',
        'value' => function(Income $model){
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
        'attribute' => 'product_type_id',
        'format' => 'raw',
        'width' => '160px',
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => ArrayHelper::map(ProductList::find()->andWhere(['!=', 'type_id', ProductList::TYPE_PRODUCT])->all(), 'id', 'product_name'),
            'options' => [
                'placeholder' => 'Mahsulotni tanlang...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
        'value' => function (Income $model) {
            return Html::a($model->productType->product_name, Url::to(['/income/result', 'id' => $model->id,]), ['data-pjax' => '0']);
        }

    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'cost',
        'width' => '100px',
        'value' => function (Income $model) {
            return $model->cost . ' ' . $model->typesName;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'provider_id',
        'format' => 'raw',
        'width' => '160px',
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => Client::getProvider(),
            'options' => [
                'placeholder' => 'Klientni tanlang...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
        'value' => function (Income $model) {
            return $model->provider->fulla_name;
        }

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
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'length',
        'label' => 'Qolgan metri',
        'width' => '130px',
        'value' => function (Income $model) {
            if ($model->unityType->id == 2) {
                return $model->length . ' metr';
            } else {
                return 0;
            }
        }
    ],


//    [
//        'attribute' => 'price_per_meter',
//        'width' => '160px',
//        'format' => ['decimal', 2],
//
//    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'total',
        'format' => ['decimal', 3],
        'width' => '120px',
        'pageSummary' => true,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'cost_of_living',
        'format' => ['decimal', 0],
        'pageSummary' => true,
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'template' => '{delete}',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false,// for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'],
    ],

];
