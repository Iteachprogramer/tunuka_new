<?php

use common\models\Outcome;
use common\models\ProductList;
use kartik\daterange\DateRangePicker;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mahsulot';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

$css = <<< CSS
.kv-panel-before{
font-size: 25px;
}
CSS;
$this->registerCss($css);
$product_arr = \soft\helpers\ArrayHelper::map(
    ProductList::find()->andWhere([
        'in',
        'id',
        Outcome::find()->select('outcome.product_type_id')->joinWith('productType'),
    ])
        ->andwhere(['type_id' => ProductList::TYPE_AKSESSUAR])
        ->all(),
    'id',
    'product_name'
);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="width: 100%">
                <form class="form-inline" action="<?= Url::to(['outcome/aksessuar-report-search']) ?>" id="aksessuar-report">
                    <?php
                    /** @var Load $model */
                    echo DateRangePicker::widget([
                        'name' => 'range',
                        'attribute' => 'date_range',
                        'presetDropdown' => true,
                        'convertFormat' => true,
                        'includeMonthsFilter' => true,
                        'startAttribute' => 'datetime_min',
                        'endAttribute' => 'datetime_max',
                        'pluginOptions' => [
                            'timePickerIncrement' => 30,
                            'locale' => [
                                'format' => 'Y-m-d H:i:s'
                            ]
                        ]
                    ]);
                    ?>
                    <?= Html::submitButton('<i class="fas fa-search"></i> Qidirish ', ['class' => 'btn btn-primary text-white', 'style' => 'margin-left:5px']) ?>
                </form>
            </div>
        </div>
        <br>


        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?= $this->render('info_outcome') ?>
<?php


?>
<a id="downloadLink" class="btn btn-primary fa fa-file-excel-o" style="margin-bottom: 15px;padding: 10px;display: none;width: 140px">
    Hisobot olish</a>
<div class="outcome-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => false,
            'showPageSummary' => true,
            'toolbarButtons' => [
                'create' => false,
            ],
            'columns' => [
                [
                    'attribute' => 'product_type_id',
                    'format' => 'raw',
                    'width' => '220px',
                    'value' => function (Outcome $model) {
                        return $model->productType->product_name;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'data' => $product_arr,
                        'options' => [
                            'placeholder' => 'Klientni tanlang...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ],
                ],
                [
                    'attribute' => 'created_at',
                    'width' => '160px',
                    'value' => function (Outcome $model) {
                        return Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s');
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
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'cost',
                    'format' => 'integer',
                    'width' => '150px',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'count',
                    'pageSummary' => true,
                    'value' => function (Outcome $model) {
                        if ($model->unit_id == 2) {
                            return $model->count ;
                        } else {
                            return $model->count . ' ' . $model->unity->name;
                        }
                    },
                ],
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
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'vAlign' => 'middle',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::to([$action, 'id' => $key]);
                    },
                    'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
                    'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
                    'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
                        'data-confirm' => false, 'data-method' => false,// for overide yii data api
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => 'Are you sure?',
                        'data-confirm-message' => 'Are you sure want to delete this item'],
                ],
            ],
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    'size' => Modal::SIZE_LARGE,
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">

        </div>
    </div>
</div>
<?php
$js2 = <<< JS
    $(document).on('submit', '#aksessuar-report', function(e){
        e.preventDefault()
        let rulons=$('#aksessuar-report')
        let elem = $('#downloadLink');
          $.ajax({
            url: rulons.attr('action'),
            data: rulons.serialize(),
            success: function(result){
            $('#downloadLink').css('display','block')
             let data = result.message
                var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(data); 
                elem.attr("href", url);
                elem.attr("download", "Aksessuar.xls"); // Choose the file name
            }
        })
    })
  
JS;
$this->registerJs($js2)
?>
