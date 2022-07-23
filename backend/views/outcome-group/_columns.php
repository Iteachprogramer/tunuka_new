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
        'width' => '170px',
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
        'width' => '140px',
        'value' => function (OutcomeGroup $model) {
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
        'width' => '100px',
        'format' => 'integer',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'total',
        'format' => 'integer',
        'pageSummary' => true,
        'value' => function (OutcomeGroup $model) {
            return $model->total ? $model->total : $model->outcomeSum;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => "To'langan summa",
        'format' => 'integer',
        'pageSummary' => true,
        'value' => function (OutcomeGroup $model) {
            return $model->accountSum;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => "Qolgan summa",
        'format' => 'integer',
        'pageSummary' => true,
        'value' => function (OutcomeGroup $model) {
            return ($model->total ? $model->total : $model->outcomeSum) - $model->accountSum;
        }
    ],
    [
        'attribute' => 'created_by',
        'format' => 'raw',
        'label' => 'Sotuvchi',
        'value' => function (OutcomeGroup $model) {
            return $model->createdBy->firstname .' ' . $model->createdBy->lastname;
        }
    ],
    'order_number',
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{update} {print} {excel} {cash} {point}  {delete} ',
        'width' => '140px',
        'vAlign' => 'middle',
//        'urlCreator' => function ($action, $model, $key, $index) {
//            return Url::to([$action, 'id' => $key]);
//        },
        'buttons' => [
            'print' => function ($url, $model) {
                return Html::a('<i class="fa fa-print"></i>', '#', ['class' => 'printButton', 'data-id' => $model->id]);
            },
            'excel' => function ($url, $model) {
                return Html::a('<i class="fa fa-file-excel"></i>', '#', ['class' => 'downloadLink', 'data-id' => $model->id, 'data-pjax' => '0']);
            },
            'cash' => function ($url, $model) {
                return Html::a('<i class="fa fa-dollar-sign"></i>', Url::to(['outcome-group/cash', 'id' => $model->id]), ['class' => 'cashButton', 'role' => 'modal-remote',]);
            },
            'point' => function ($url, $model) {
                return Html::a('<i class="fa fa-hand-holding-usd"></i>', Url::to(['outcome-group/point', 'id' => $model->id]), ['class' => 'pointButton', ]);
            },
        ],
        'visibleButtons'=>[
            'point' => function ($model) {
                return $model->prasent_status == OutcomeGroup::PRASENT_NOT_POINT;
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
