<?php

use common\models\Client;
use common\models\OutcomeGroup;
use soft\grid\GridView;
use soft\helpers\Html;
use yii\helpers\Url;

return [
    [
        'attribute' => 'client_id',
        'format' => 'raw',
        'width' => '220px',
        'value' => function (OutcomeGroup $model) {
            return Html::a($model->client->fulla_name, Url::to(['/outcome/rulon-index', 'id' => $model->id,]), ['data-pjax' => '0']);
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data' => Client::getClient(),
            'options' => [
                'placeholder' => 'Klientni tanlang...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
    ],
    [
        'attribute' => 'date',
        'width' => '160px',
        'value' => function(OutcomeGroup $model){
            return Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i:s');
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
        'attribute' => 'discount',
        'format' => 'integer',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'total',
        'format' => 'integer',

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{update} {view} {delete} {print}',
        'vAlign' => 'middle',
//        'urlCreator' => function ($action, $model, $key, $index) {
//            return Url::to([$action, 'id' => $key]);
//        },
        'buttons' => [
            'print' => function ($url, $model) {
                return Html::a('<i class="fa fa-print"></i>', '#', ['class' => 'printButton', 'data-id' => $model->id]);
            },
        ],
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
