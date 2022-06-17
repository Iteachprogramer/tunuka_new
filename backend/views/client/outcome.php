<?php

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
echo $this->render('info_outcome',['model'=>$model]);
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
                    'url' => \soft\helpers\Url::to(['/client/create-aksessuar']),
                    'cssClass' => 'btn btn-outline-secondary',
                ],
            ],
            'columns' => require(__DIR__.'/outcome_columns/aksessuar_columns.php'),
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
