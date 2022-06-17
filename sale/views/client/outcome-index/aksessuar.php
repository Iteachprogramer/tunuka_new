<?php

use common\models\Client;
use common\models\Outcome;
use common\models\ProductList;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Outcomes');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
echo $this->render('../info_outcome',['client_id'=>$client_id]);
?>
<div class="outcome-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'toolbarTemplate' => "{aksessuar}",
            'pjax'=>true,
            'showPageSummary' => true,
            'toolbarButtons' => [
                'aksessuar' => [
                    'pjax' => false,
                    'modal' => true,
                    'icon' => 'plus',
                    'url' => \soft\helpers\Url::to(['client/create-aksessuar','id'=>$client_id]),
                    'cssClass' => 'btn btn-outline-secondary',
                ],
            ],
            'columns' =>
            [
                [
                    'class' => 'kartik\grid\CheckboxColumn',
                    'width' => '20px',
                ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
                    // [
                    // 'class'=>'\kartik\grid\DataColumn',
                    // 'attribute'=>'id',
                    // ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'client_id',
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
                        'value' => function (Outcome $model) {
                            return $model->client->fulla_name;
                        },
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'product_type_id',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'data' => ProductList::getAksessuar(),
                            'options' => [
                                'placeholder' => 'Mahsulotni tanlang...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ]
                        ],
                        'value' => function (Outcome $model) {
                            return $model->productType->product_name;
                        },
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'cost',
                        'format' => 'integer',
                        'width' => '150px',
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'count',
                        'value' => function (Outcome $model) {
                            if ($model->unit_id == 2) {
                                return $model->count ;
                            } else {
                                return $model->count . ' ' . $model->unity->name;
                            }
                        },
                    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'total_size',
//    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'total',
                        'format' => 'integer',
                        'pageSummary' => true,
                    ],

                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'dropdown' => false,
                        'vAlign'=>'middle',
                        'urlCreator' => function($action, $model, $key, $index) {
                            return Url::to([$action,'id'=>$key]);
                        },
                        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
                        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
                        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-toggle'=>'tooltip',
                            'data-confirm-title'=>'Are you sure?',
                            'data-confirm-message'=>'Are you sure want to delete this item'],
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
<?php
$js = <<< JS
$('.close').click(function (e){
    e.preveDefault();
    alert('salom');
})
JS;
$this->registerJs($js);


?>
