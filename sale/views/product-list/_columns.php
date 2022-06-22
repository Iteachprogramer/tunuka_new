<?php

use common\models\ProductList;
use yii\helpers\Url;

return [

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'product_name',
    ],
    array(
        'attribute' => 'type_id',
        'format' => 'raw',
        'filter' => ProductList::types(),
        'value' => function (ProductList $model) {
            if ($model->type_id == ProductList::TYPE_RULON) {
                return '<span class="badge badge-danger">' . "Rulon" . '</span>';
            } elseif ($model->type_id == ProductList::TYPE_PRODUCT) {
                return '<span class="badge badge-success">' . "Mahsulot" . '</span>';
            } else {
                return '<span class="badge badge-warning">' . "Aksessuar" . '</span>';
            }
        },
    ),
    [
        'attribute' => 'selling_price_uz',
        'format' => 'integer',
        'width' => '140px',
    ],

    [
        'attribute' => 'residue',
        'width' => '100px',
        'value' => function (ProductList $model) {
                return number_format($model->residual,2,'.','') . ' ' . $model->sizeType->name;
        }
    ],
    [
        'attribute' => 'residualCost',
        'label' => 'Umumiy summa',
        'format' => 'integer',
        'value' => function(ProductList $model){
            return $model->residual * $model->selling_price_uz;
        },
        'pageSummary' => true,
    ],
];
