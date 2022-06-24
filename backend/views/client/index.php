<?php

use kartik\daterange\DateRangePicker;
use soft\grid\GridView;
use soft\widget\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klientlar';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6" style="width: 100%">
            <form action="<?= Url::to(['/client/excel-export']) ?>" class="form-inline export-form">
                <?php
                /** @var TYPE_NAME $model */
                echo DateRangePicker::widget([
                    'name' => 'range',
                    'attribute' => 'date_range',
                    'presetDropdown' => true,
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
                <?= Html::submitButton('<i class="fas fa-search"></i> Hisobot olish', ['class' => 'btn btn-primary text-white export', 'style' => 'margin-left:5px']) ?>
            </form>
        </div>
    </div>
    <br>
</div><!-- /.container-fluid -->

<div class="client-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'pagerDropDown' => true,
            'exportButton' => false,
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
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer" => "",// always need it for jquery plugin
]) ?>
<div id="export-div" style="display: none">

</div>
<?php Modal::end(); ?>
<?php
$js = <<<JS
$(document).on('click', '.export', function(e){
    e.preventDefault();
    $.ajax({
            url: $('.export-form').attr('action'),
            data: $('.export-form').serialize(),
            success: function(result)
            {
                
            }
        })
})
JS;
$this->registerJs($js);
?>

