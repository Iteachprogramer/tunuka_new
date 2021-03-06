<?php

use common\models\Account;
use common\models\Client;
use common\models\OutcomeGroup;
use kartik\daterange\DateRangePicker;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var Client $client_id */
/** @var Account $date */
$this->title = 'Yuk sotish';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="width: 100%">
                <form class="form-inline" action="<?= Url::to(['outcome-group/client-reports']) ?>" id="client-reports">
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
                                'format' => 'Y-m-d'
                            ]
                        ]
                    ]);
                    ?>
                    <?= Html::submitButton('<i class="fas fa-search"></i> Qidirish ', ['class' => 'btn btn-primary text-white', 'style' => 'margin-left:5px']) ?>
                    <input type="hidden" name="client_id" value="<?=$client_id?>">
                </form>
            </div>
        </div>
        <br>


        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<a id="downloadLink" class="btn btn-primary fa fa-file-excel-o" style="margin-bottom: 15px;padding: 10px;display: none;width: 140px">
    Hisobot olish</a>
<div class="outcome-group-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => false,
            'toolbarButtons' => [
                'create' => false
            ],
            'columns' => [
                [
                    'attribute' => 'client_id',
                    'format' => 'raw',
                    'width' => '220px',
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
                    'width' => '160px',
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
                'order_number',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'template' => '{update} {view} {delete} {print} {excel} {cash}',
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
                        }
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
            ],

        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
<div id="excel">
</div>
<div id="table" style="display: none">
    <?php
    $url = Url::to(['outcome-group/check-print']);
    ?>
</div>

<input type="hidden" value="<?= $url ?>" name="url_group">
<?php
$excel_url = Url::to(['outcome-group/excel']);
$js = <<< JS
     $(document).on('click','.printButton',function (e) {
        let url = $('input[name=url_group]').val()
        var id = this.getAttribute("data-id");
        $.ajax({
            url: url, type: 'GET', data: {id: id}, success: async function (result) {
                let data = result.message
                $('#table').html(data);
                w = window.open();
                w.document.write($('#table').html());
                await new Promise(r => setTimeout(r, 2000))
                w.print();
                w.close()
            }
        })
    })
    $(document).on('click','.downloadLink',function (e){
        var id = this.getAttribute("data-id");
        let elem = $(this);
        $.ajax({
            url: '$excel_url',
             type: 'GET', 
             data: {id: id},
             success:  function (result) {
                let data = result.message
                $('#excel').html(data);
                let excel_url=document.getElementById('excel');
                var html = excel_url.outerHTML;
                var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(html); 
                elem.attr("href", url);
                elem.attr("download", "Hisobot.xls"); // Choose the file name
             }
        })

    })
JS;
$this->registerJs($js, View::POS_END);

$js2 = <<< JS
    $(document).on('submit', '#client-reports', function(e){
        e.preventDefault()
        let rulons=$('#client-reports')
        let elem = $('#downloadLink');
          $.ajax({
            url: rulons.attr('action'),
            data: rulons.serialize(),
            success: function(result){
            $('#downloadLink').css('display','block')
             let data = result.message
                var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(data); 
                elem.attr("href", url);
                elem.attr("download", "Mijoz.xls"); // Choose the file name
            }
        })
    })
  
JS;
$this->registerJs($js2)

?>

