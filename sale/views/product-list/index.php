<?php

use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProductListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title ='Sklad' ;
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="product-list-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'pagerDropDown' => true,
            'exportButton' => false,
            'showPageSummary' => true,
            'toolbarButtons' => [
                'create' =>false,
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>