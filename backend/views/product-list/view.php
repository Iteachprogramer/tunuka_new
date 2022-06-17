<?php


/* @var $this yii\web\View */

/* @var $model common\models\ProductList */

use common\models\ProductList;
use soft\widget\bs4\DetailView;

?>
<div class="product-list-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_name',
            [
                'attribute' => 'type_id',
                'value' => function (ProductList $model) {
                    return $model->typesName;
                }
            ],
            [
                    'attribute' => 'residue',
                    'value' => function (ProductList $model) {
                        return $model->residual . ' ' . $model->sizeType->name;
                    }
            ],

            [
                'attribute' => 'selling_price_uz',
                'value' => function (ProductList $model) {
                    return $model->selling_price_uz;
                }
            ],
//            [
//                'attribute' => 'selling_price_usd',
//                'value' => function (ProductList $model) {
//                    return $model->selling_price_usd . '$';
//                }
//            ],
//            'selling_rentail',
            'created_at',
            'updated_at',
            [
                'attribute' => 'created_by',
                'value' => function (ProductList $model) {
                    return $model->createdBy->username;
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function (ProductList $model) {
                    return $model->updatedBy->username;
                }
            ],
        ],
    ]) ?>

</div>
