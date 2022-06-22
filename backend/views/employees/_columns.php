<?php

use common\models\Employees;
use soft\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'name',
        'format' => 'raw',
        'value' => function (Employees $model) {
            if ($model->is_factory==Employees::IS_FACTORY_YES){
                return Html::a($model->name, ['/employees/make-product', 'employee_id' => $model->id], ['data-pjax' => '0']);
            }
            else{
                return$model->name;
            }
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'salary',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'is_factory',
        'format' => 'raw',
        'filter' => Employees::getIsFactoryList(),
        'value' => function (Employees $model) {
            if ($model->is_factory == Employees::IS_FACTORY_YES) {
                return '<span class="badge badge-success">Ha</span>';
            } else {
                return '<span class="badge badge-danger">Yo\'q</span>';
            }
        },
    ],
    [
        'attribute' => 'status',
        'format' => 'raw',
        "filter" => Employees::getStatusList(),
        'value' => function (Employees $model) {
            if ($model->status == Employees::STATUS_ACTIVE) {
                return '<span class="badge badge-success">Ishlayabdi</span>';
            } else {
                return '<span class="badge badge-danger">Ishlamayabdi</span>';
            }
        },
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_by',
        'value' => 'createdBy.username',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'updated_by',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'template' => '{update} {view}',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
    ],

];
