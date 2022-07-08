<?php

use kartik\daterange\DateRangePicker;
use kartik\helpers\Html;
use soft\grid\GridView;
use soft\helpers\Url;
use soft\widget\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;

$this->title = 'Olingan yuklar';
/* @var $this \yii\web\View */
/* @var $model \common\models\Client */
/* @var $searchModel \common\models\search\ClientSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = 'Olingan yuklar';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_clientMenu', ['model' => $model]) ?>
<?= $this->render('info', ['model' => $model]) ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6" style="width: 100%">
                    <form class="form-inline" action="<?= Url::to(['client/incomes-report']) ?>" id="incomes-report">
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
                        <input type="hidden" name="client" value="<?= $model->id ?>">
                        <?= Html::submitButton('<i class="fas fa-search"></i> Qidirish ', ['class' => 'btn btn-primary text-white', 'style' => 'margin-left:5px']) ?>
                    </form>
                </div>
            </div>
            <br>


            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <a id="downloadLink" class="btn btn-primary fa fa-file-excel-o"
       style="margin-bottom: 15px;padding: 10px;display: none;width: 140px">
        Hisobot olish</a>
<?php CrudAsset::register($this);

?>
    <div class="income-index">
        <div id="ajaxCrudDatatable">
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showPageSummary' => true,
                'toolbarButtons' => [
                    'create' => false,
                ],
                'pjax' => true,
                'columns' => require(__DIR__ . '/columns_income.php'),
            ]) ?>
        </div>
    </div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>

<?php
$js2 = <<< JS
    $(document).on('submit', '#incomes-report', function(e){
        e.preventDefault()
        let rulons=$('#incomes-report')
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