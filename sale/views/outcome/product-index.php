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

$this->title = 'Mahsulot';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
echo $this->render('info',['group'=>$group]);
$css = <<< CSS
.kv-panel-before{
font-size: 25px;
}
CSS;
$this->registerCss($css)
?>
<div class="outcome-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'toolbarTemplate' => "{product}",
            'pjax'=>true,
            'panel' => [
                'before'=>$group->client->fulla_name,
            ],
            'showPageSummary' => true,
            'toolbarButtons' => [
                'product' => [
                    'pjax' => false,
                    'modal' => true,
                    'icon' => 'plus',
                    'url' => \soft\helpers\Url::to(['/outcome/create-product','group_id'=>$group->id]),
                    'cssClass' => 'btn btn-outline-secondary',
                ],

            ],
            'columns' => require(__DIR__.'/outcome_columns/product_columns.php'),
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
