<?php

use common\models\Client;
use kartik\daterange\DateRangePicker;
use soft\grid\GridView;
use soft\widget\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klientlar';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
    <a id="downloadLink" class="btn btn-primary fa fa-file-excel-o"
       style="margin-bottom: 15px;padding: 10px"> Hisobot olish</a>
    <div class="client-index">
        <div id="ajaxCrudDatatable">
            <?= Html::beginForm(['client/select-clients'], 'post') ?>
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'pagerDropDown' => true,
                'exportButton' => false,
                'pjax' => true,
                'toolbarButtons' => [
                    'create' => [
                        'pjax' => false,
                        'modal' => true,
                        'url' => \soft\helpers\Url::to(['create']),
                        'cssClass' => 'btn btn-outline-secondary',
                        'icon' => 'plus',
                        'title' => Yii::t('site', 'Create a new'),
                    ],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => require(__DIR__ . '/_columns.php'),
            ]) ?>
            <div style="display: flex;justify-content: end">
                <?= Html::submitButton('<i class="fas fa-sms"></i> Xabar yuborish', ['class' => 'btn btn-primary']) ?>

            </div>
            <?php Html::endForm() ?>
        </div>
    </div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer" => "",// always need it for jquery plugin
]) ?>

<?php Modal::end(); ?>
<?php
$excel_url = Url::to(['client/excel']);
$js = <<< JS
    $(document).on('click','#downloadLink',function (e){
        let elem = $(this);
        $.ajax({
            url: '$excel_url',
             type: 'GET', 
             success:  function (result) {
                let data = result.message
                var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(data); 
                elem.attr("href", url);
                elem.attr("download", "Klientlar.xls"); // Choose the file name
             }
        })

    })
   
JS;
$this->registerJs($js);
?>