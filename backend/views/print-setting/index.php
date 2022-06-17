<?php

use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PrintSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Printer sozlamasi';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="print-setting-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'toolbarButtons' => [
                    'create' =>
                        [
                            'url' => Url::to(['create']),
                            'modal' => true,
                        ],
                ],
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