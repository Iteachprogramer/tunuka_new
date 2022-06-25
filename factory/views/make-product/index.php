<?php

use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MakeProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ishlab chiqarish';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
    <div class="make-product-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showPageSummary' => true,
                'pjax'=>true,
                'columns' => require(__DIR__.'/_columns.php'),
                'toolbarButtons' => [
                    'create' => [
                        'pjax' => false,
                        'modal' => true,
                        'url' => \soft\helpers\Url::to(['create']),
                        'cssClass' => 'btn btn-outline-secondary',
                        'icon' => 'plus',
                    ],
                    'refresh'=>[
                        'cssClass' => 'btn btn-outline-secondary',

                    ]
                ],

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