<?php

use common\models\Client;
use common\models\OutcomeGroup;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Yuk sotish';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="outcome-group-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,

            'toolbarButtons' => [
                'create' =>
                    [
                        'url' => Url::to(['outcome-group/create-client-outcome', 'client_id' => $client_id]),
                        'modal' => true,
                    ],
            ], 'columns' => [
                [
                    'attribute' => 'client_id',
                    'format' => 'raw',
                    'width' => '220px',
                    'value' => function (OutcomeGroup $model) {
                        return Html::a($model->client->fulla_name, Url::to(['/outcome/rulon-index', 'id' => $model->id,]), ['data-pjax' => '0']);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'data' => Client::getClientOne($client_id),
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
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'total',
                    'value' => function (OutcomeGroup $model) {
                        return $model->total ? $model->total : $model->outcomeSum;
                    }
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'template' => '{update} {view} {delete} {print} {excel}',
                    'vAlign' => 'middle',
//        'urlCreator' => function ($action, $model, $key, $index) {
//            return Url::to([$action, 'id' => $key]);
//        },
                    'buttons' => [
                        'print' => function ($url, $model) {
                            return Html::a('<i class="fa fa-print"></i>', '#', ['class' => 'printButton', 'data-id' => $model->id]);
                        },
                        'excel' => function ($url, $model) {
                            return Html::a('<i class="fa fa-file-excel"></i>', '#', ['id' => 'downloadLink','onclick'=>"exportExcel(this)" , 'data-id' => $model->id]);
                        },
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
                let style=` <style>
        @media print{
          *{
        margin: 0;
        padding: 0;
        }
        }
    </style>`;
                $('#table').html(data);
                w = window.open();
                w.document.write($('#table').html());
                await new Promise(r => setTimeout(r, 2000))
                w.print();
                w.close()
            }
        })
    })
JS;
$this->registerJs($js);
$js2 = <<< JS
 function exportExcel(elem) {
      id=elem.getAttribute("data-id");
        $.ajax({
            url: '$excel_url',
             type: 'GET', 
             data: {id: id},
             success:  function (result) {
                let data = result.message
                $('#excel').html(data);
                let excel_url=document.getElementById('excel');
                  var html = excel_url.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(html); // Set your html table into url
            elem.setAttribute("href", url);
            elem.setAttribute("download", "Hisobot.xls"); // Choose the file name
             }
        })
    }
JS;
$this->registerJs($js2, \yii\web\View::POS_HEAD);
?>

