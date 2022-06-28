<?php
use common\models\ProductList;
use soft\grid\GridView;
use soft\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\web\View;


$dataProvider = new ActiveDataProvider([
    'query' => ProductList::find()->with('sizeType'),
    'pagination' => [
        'defaultPageSize' => 50,
    ]
])

?>

<?= GridView::widget([
    'id' => 'crud-datatable',
    'pagerDropDown' => false,
    'dataProvider' => $dataProvider,
    'panel' => [
        'before' => Html::tag('h4', 'Skladdagi qoldiq', ['class' => 'text-primary'])
    ],
    'toolbarButtons' => false,
    'showPageSummary' => true,
    'columns' => [
        [
            'attribute' => 'product_name',
            'pageSummary' => function () {
                return 'Jami:';
            },
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'attribute' => 'residue',
            'width' => '100px',
            'value' => function (ProductList $model) {
                return number_format($model->residual,0,' ',' ') . ' ' . $model->sizeType->name;
            }
        ],
        [
            'attribute' => 'selling_price_uz',
            'format' => 'integer',
            'pageSummary'=>true,
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
    ],
]); ?>
