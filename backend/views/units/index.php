<?php

use soft\grid\GridView;
use soft\widget\bs4\Card;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UnitsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'O\'lchov Birliklari';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbarButtons' => [
                    'create'=>[
                            'modal'=>true,
                    ]
            ],

        ])?>
    </div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
