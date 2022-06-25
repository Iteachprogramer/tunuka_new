<?php

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

$this->title = 'Mahsulot';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
echo $this->render('info_outcome');

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
        ->andwhere(['type_id' => ProductList::TYPE_PRODUCT])
        ->all(),
    'id',
    'product_name'
);
?>
<a id="downloadLink" onclick="exportF(this)" class="btn btn-primary fa fa-file-excel-o" style="margin-bottom: 15px;padding: 10px"> Hisobot olish</a>

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
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'cost',
                    'format' => 'integer',
                    'width' => '150px',
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'total_size',
                    'pageSummary' => true,

                    'value' => function (Outcome $model) {
                        return $model->total_size . ' ' . $model->unity->name;
                    }
                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'total',
                    'format' => 'integer',
                    'pageSummary' => true,
                ],
                // [
                // 'class'=>'\kartik\grid\DataColumn',
                // 'attribute'=>'unit_id',
                // ],
                // [
                // 'class'=>'\kartik\grid\DataColumn',
                // 'attribute'=>'discount',
                // ],
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
            <table border="1" cellspacing="0" cellpadding="3" id="myTable"
                   style="text-align: center; align-items: center;display: none;width: 100%!important;"
                   class="table table-bordered table-striped">
                <tr>
                    <td style="vertical-align: middle; text-align: center">Mahsulot</td>
                    <td style="vertical-align: middle; text-align: center">Sana</td>
                    <td style="vertical-align: middle; text-align: center">Narx</td>
                    <td style="vertical-align: middle; text-align: center">O'lchami</td>
                    <td style="vertical-align: middle; text-align: center">Umumiy summa</td>
                </tr>
                <?php
                $roducts_summa = 0;
                $roducts_total_size = 0;
                $roducts = $dataProvider->getModels();
                ?>
                <?php foreach ($roducts as $product): ?>
                    <tr>
                        <td style="vertical-align: middle; text-align: center"><?= $product->productType->product_name ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= Yii::$app->formatter->asDatetime($product->created_at, 'php:d.m.Y H:i:s') ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= as_integer($product->cost) ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= $product->total_size . ' ' . $product->unity->name ?></td>
                        <td style="vertical-align: middle; text-align: center"><?= as_integer($product->total) ?></td>
                    </tr>
                    <?php
                    $roducts_summa += $product->total;
                    $roducts_total_size += $product->total_size;
                    ?>
                <?php endforeach; ?>
                <tr>
                    <td style="vertical-align: middle; text-align: center"></td>
                    <td style="vertical-align: middle; text-align: center"></td>
                    <td style="vertical-align: middle; text-align: center"></td>

                    <td style="vertical-align: middle; text-align: center"><?= $roducts_total_size ?> metr</td>
                    <td style="vertical-align: middle; text-align: center"><?= as_integer($roducts_summa) ?></td>
                </tr>
            </table>

        </div>
    </div>
</div>

<?php
$js = <<<JS
        function exportF(elem) {
        var table = document.getElementById("myTable");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Mahsulotlar.xls"); // Choose the file name
        return false;
    }
JS;
$this->registerJs($js, \yii\web\View::POS_HEAD);
?>
