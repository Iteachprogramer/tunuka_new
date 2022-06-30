<?php

use common\models\Client;
use common\models\Outcome;
use common\models\OutcomeGroup;
use common\models\ProductList;
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

$this->title = 'Yuk sotish';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<a id="downloadLink" onclick="exportF(this)" class="btn btn-primary fa fa-file-excel-o"
   style="margin-bottom: 15px;padding: 10px"> Hisobot olish</a>
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
                    'attribute' => 'Mijoz',
                    'format' => 'raw',
                    'width' => '220px',
                    'value' => function (OutcomeGroup $model) {
                        return Html::a($model->client->fulla_name, Url::to(['/outcome/rulon-index', 'id' => $model->id,]), ['data-pjax' => '0']);
                    },
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
                            return Html::a('<i class="fa fa-file-excel"></i>', '#', ['class' => 'downloadLink', 'data-id' => $model->id, 'data-pjax' => '0']);
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
<div id="report-client-all">
    <?php
    $groups = $dataProvider->getModels();
    ?>
    <table cellspacing="0" cellpadding="3"
           style="text-align: center; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">
        <tr>
            <td colspan="4" style="text-align: center; align-items: center;">Mijoz:</td>
            <td colspan="4" style="text-align: center; align-items: center;"><?= $groups[0]->client->fulla_name ?></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center; align-items: center;">Xisobot chop etilgan sana</td>
            <td colspan="4"
                style="text-align: center; align-items: center;"><?= Yii::$app->formatter->asDate(time(), 'php:d.m.Y') ?></td>
        </tr>
    </table>
    <br>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: center; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">
        <tr>
            <td colspan="8" style="vertical-align: middle; text-align: center"> Rulonlar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: center;align-items: center">Tovar nomi</td>
            <td style="text-align: center;align-items: center">Sana</td>
            <td style="text-align: center;align-items: center">O'lchami</td>
            <td style="text-align: center;align-items: center">soni</td>
            <td style="text-align: center;align-items: center">Umumiy metr</td>
            <td style="text-align: center;align-items: center">Narxi</td>
            <td style="text-align: center;align-items: center">Umumiy summa</td>
        </tr>
        <?php
        $rulon_sum = 0;
        $rulon_length = 0;
        ?>
        <?php foreach ($groups as $group): ?>
            <?php
            $outcomes = Outcome::find()->andWhere(['group_id' => $group->id])->andWhere(['type_id' => ProductList::TYPE_RULON])->with('productType', 'unity')->all();
            ?>
            <?php if ($outcomes): ?>
                <?php foreach ($outcomes as $key => $outcome): ?>
                    <?php
                    $rulon_sum += $outcome->total;
                    $rulon_length += $outcome->total_size;
                    ?>
                    <tr>
                        <td style="text-align: center;align-items: center"><?= $key + 1 ?></td>
                        <td style="text-align: center;align-items: center"><?= $outcome->productType->product_name ?></td>
                        <td style="text-align: center;align-items: center"><?= Yii::$app->formatter->asDatetime($group->date, 'php:d.m.Y H:i:s') ?></td>
                        <td style="text-align: center;align-items: center"><?= number_format($outcome->size). ' metr' ?></td>
                        <td style="text-align: center;align-items: center"><?= $outcome->count ?></td>
                        <td style="text-align: center;align-items: center"><?= number_format($outcome->total_size, 2) . ' ' . $outcome->unity->name ?></td>
                        <td style="text-align: center;align-items: center"><?= as_integer($outcome->cost) ?></td>
                        <td style="text-align: center;align-items: center"><?= as_integer($outcome->total) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;align-items: center"><?= number_format($rulon_length, 2) . ' ' . $outcome->unity->name ?></td>
            <td></td>
            <td style="text-align: center;align-items: center"><?= as_integer($rulon_sum) ?></td>
        </tr>
    </table>
    <br>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: center; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">

        <tr>
            <td colspan="6" style="vertical-align: middle; text-align: center">Mahsulotlar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: center;align-items: center">Mahsulot nomi</td>
            <td style="text-align: center;align-items: center">Sana</td>
            <td style="text-align: center;align-items: center">O'lchami</td>
            <td style="text-align: center;align-items: center">Narxi</td>
            <td style="text-align: center;align-items: center">Umumiy summa</td>
        </tr>
        <?php
        $outcomes_product_sum = 0;
        $outcome_products_total_size = 0;
        ?>
        <?php foreach ($groups as $group): ?>
            <?php $outcome_products = Outcome::find()->andWhere(['group_id' => $group->id])->andWhere(['type_id' => ProductList::TYPE_PRODUCT])->with('productType', 'unity')->all() ?>
            <?php if ($outcome_products): ?>
                <?php foreach ($outcome_products as $key => $outcome_product): ?>
                    <?php
                    $outcomes_product_sum += $outcome_product->total;
                    $outcome_products_total_size += $outcome_product->total_size;
                    ?>
                    <tr>
                        <td style="text-align: center;align-items: center"><?= $key + 1 ?></td>
                        <td style="text-align: center;align-items: center"><?= $outcome_product->productType->product_name ?></td>
                        <td style="text-align: center;align-items: center"><?= Yii::$app->formatter->asDatetime($group->date, 'php:d.m.Y H:i:s') ?></td>
                        <td style="text-align: center;align-items: center"><?= number_format($outcome_product->total_size, 2) . ' ' . $outcome_product->unity->name ?></td>
                        <td style="text-align: center;align-items: center"><?= as_integer($outcome_product->cost) ?></td>
                        <td style="text-align: center;align-items: center"><?= as_integer($outcome_product->total) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;align-items: center"><?= number_format($outcome_products_total_size, 2) . ' ' . $outcome_product->unity->name ?></td>
            <td></td>
            <td style="text-align: center;align-items: center"><?= as_integer($outcomes_product_sum) ?></td>
        </tr>
    </table>
    <br>
    <table border="1" cellspacing="0" cellpadding="3"
           style="text-align: center; align-items: center;display: none;width: 100%!important;"
           class="table table-bordered table-striped">

        <tr>
            <td colspan="6" style="vertical-align: middle; text-align: center">Aksessuar</td>
        </tr>
        <tr>
            <td>№</td>
            <td style="text-align: center;align-items: center">Mahsulot nomi</td>
            <td style="text-align: center;align-items: center">Sana</td>
            <td style="text-align: center;align-items: center">Miqdori</td>
            <td style="text-align: center;align-items: center">Narxi</td>
            <td style="text-align: center;align-items: center">Umumiy summa</td>
        </tr>
        <?php
        $outcome_aksessuar_sum = 0;
        ?>
        <?php foreach ($groups as $group): ?>
            <?php $outcome_aksessuars = Outcome::find()->andWhere(['group_id' => $group->id])->andWhere(['type_id' => ProductList::TYPE_AKSESSUAR])->with('productType', 'unity')->all() ?>
            <?php if ($outcome_aksessuars): ?>
                <?php foreach ($outcome_aksessuars as $key => $outcome_aksessuar): ?>
                    <?php
                    $outcome_aksessuar_sum += $outcome_aksessuar->total;
                    ?>
                    <tr>
                        <td style="text-align: center;align-items: center"><?= $key + 1 ?></td>
                        <td style="text-align: center;align-items: center"><?= $outcome_aksessuar->productType->product_name ?></td>
                        <td style="text-align: center;align-items: center"><?= Yii::$app->formatter->asDatetime($group->date, 'php:d.m.Y H:i:s') ?></td>
                        <td style="text-align: center;align-items: center"><?= number_format($outcome_aksessuar->count, 2) . ' ' . $outcome_aksessuar->unity->name ?></td>
                        <td style="text-align: center;align-items: center"><?= as_integer($outcome_aksessuar->cost) ?></td>
                        <td style="text-align: center;align-items: center"><?= as_integer($outcome_aksessuar->total) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;align-items: center"><?= as_integer($outcome_aksessuar_sum) ?></td>
    </table>
    <br>
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
      function exportF(elem) {
        var table = document.getElementById("report-client-all");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Mijozlar.xls"); // Choose the file name
        return false;
    }
JS;
$this->registerJs($js, View::POS_END);

?>

