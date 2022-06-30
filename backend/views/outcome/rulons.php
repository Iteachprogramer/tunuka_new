<?php

use common\models\Outcome;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sotilgan Rulonlar';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$css = <<< CSS
.kv-panel-before{
font-size: 25px;
}
CSS;
$this->registerCss($css)
?>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<?=$this->render('info_outcome')?>
<a id="downloadLink" onclick="exportF(this)" class="btn btn-primary fa fa-file-excel-o" style="margin-bottom: 15px;padding: 10px"> Hisobot olish</a>

<div class="outcome-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => false,
            'showPageSummary' => true,
            'toolbarButtons' => false,
            'columns' => [
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'Rulon',
                    'value' => function (Outcome $model) {
                        return $model->productType->product_name;
                    },
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
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'cost',
                    'format' => 'integer',
                    'width' => '150px',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'size',
                    'value' => function (Outcome $model) {
                        return $model->size . ' ' . $model->unity->name;
                    },
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'count',
                    'value' => function (Outcome $model) {
                        if ($model->unit_id == 2) {
                            return $model->count;
                        } else {
                            return $model->count . ' ' . $model->unity->name;
                        }
                    },
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'total_size',
                    'pageSummary' => true,
                    'value' => function (Outcome $model) {
                        return $model->total_size . ' ' . $model->unity->name;
                    },
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'total',
                    'format' => 'integer',
                    'pageSummary' => true,
                ],
            ],
        ]) ?>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table border="1" cellspacing="0" cellpadding="3" id="myTable"
                   style="text-align: center; align-items: center;display: none;width: 100%!important;"
                   class="table table-bordered table-striped">
                <tr>
                    <td style="vertical-align: middle; text-align: center">Rulon</td>
                    <td style="vertical-align: middle; text-align: center">Sana</td>
                    <td style="vertical-align: middle; text-align: center">Narx</td>
                    <td style="vertical-align: middle; text-align: center">O'lchami</td>
                    <td style="vertical-align: middle; text-align: center">Miqdori</td>
                    <td style="vertical-align: middle; text-align: center">Umumiy o'lcham</td>
                    <td style="vertical-align: middle; text-align: center">Umumiy summa</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                </tr>
                <?php
                $rulons_summa = 0;
                $rulons_total_size = 0;
                $rulons = $dataProvider->getModels();
                ?>
                <?php foreach ($rulons as $rulon): ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: center"><?= $rulon->productType->product_name ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= Yii::$app->formatter->asDatetime($rulon->created_at, 'php:d.m.Y H:i:s') ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= $rulon->cost ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= $rulon->size . ' ' . $rulon->unity->name ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= $rulon->count ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= $rulon->total_size . ' ' . $rulon->unity->name ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= $rulon->total ?></td>
                    </tr>
                    <?php
                    $rulons_summa += $rulon->total;
                    $rulons_total_size += $rulon->total_size;
                    ?>
                <?php endforeach; ?>
                <tr>
                    <td style="vertical-align: middle; text-align: center"></td>
                    <td style="vertical-align: middle; text-align: center"></td>
                    <td style="vertical-align: middle; text-align: center"></td>
                    <td style="vertical-align: middle; text-align: center"></td>
                    <td style="vertical-align: middle; text-align: center"></td>
                    <td style="vertical-align: middle; text-align: center"><?= $rulons_total_size ?> metr</td>
                    <td style="vertical-align: middle; text-align: center"><?= $rulons_summa ?></td>
                </tr>
            </table>

        </div>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    'size' => Modal::SIZE_LARGE,
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
<?php
$js = <<<JS
        function exportF(elem) {
        var table = document.getElementById("myTable");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Rulonlar.xls"); // Choose the file name
        return false;
    }
JS;
$this->registerJs($js, \yii\web\View::POS_HEAD);
?>
