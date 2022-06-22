<?php

use common\models\MakeProduct;
use common\models\ProductList;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MakeProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ishlab chiqarish';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
    <p><a href="<?= to(['employees/index']) ?>" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Ortga qaytish </a></p>
    <div class="make-product-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showPageSummary' => true,
                'pjax'=>true,
                'toolbarButtons' => [
                    'create' =>false,
                    'refresh'=>[
                        'cssClass' => 'btn btn-outline-secondary',

                    ]
                ],
                'columns' => [
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
                ],


            ])?>
        </div>
    </div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>