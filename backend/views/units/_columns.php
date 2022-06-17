<?php

use common\models\Units;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'format' => 'raw',
        'filter' => Units::statuses(),
        'value' => function ($model) {
         return $model->status == Units::STATUS_ACTIVE ? '<span class="badge badge-success">Faol</span>' : 'Faol emas';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_by',
        'value' => function (Units $model) {
             return $model->createdBy0->username;
        }
    ],
     'created_at:datetime',
];
