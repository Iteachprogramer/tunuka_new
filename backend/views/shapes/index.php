<?php

use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ShapesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shapes');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="shapes-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'toolbarButtons' => [
                'create' => [
                    'pjax' => false,
                    'modal' => true,
                    'url' => \soft\helpers\Url::to(['create']),
                    'cssClass' => 'btn btn-outline-secondary',
                    'icon' => 'plus',
                    'title' => 'Yangi shakil qo\'shish',
                ],

                'refresh' => [
                    'url' => Url::current(),
                    'icon' => 'sync-alt',
                    'cssClass' => 'btn btn-outline-secondary',
                    'title' =>'Yangilash',
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