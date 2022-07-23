<?php

use common\models\OutcomeGroup;
use common\modules\point\models\PointSystem;
use yii\helpers\Url;

return [
    ['class' => '\yii\grid\CheckboxColumn',
        'checkboxOptions' => function ($model, $key, $index, $column) {
            if ($model->point != 0) {
                return ['value' => $key];
            }
            return ['style' => ['display' => 'none']]; // OR ['disabled' => true]
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'client_id',
        'format' => 'raw',
        'value' => function (PointSystem $model) {
            return $model->client->fulla_name;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'point',
    ],

];
