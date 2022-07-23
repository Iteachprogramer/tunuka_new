<?php

use soft\grid\GridView;
use soft\widget\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\point\models\search\PointSystemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Balli tizimining hisoboti";
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="point-system-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbarButtons' => [
                    'create'=>false,
            ],
            'bulkButtonsTemplate' => '{point-refresh}',
            'bulkButtons' => [
                'point-refresh' => [
                    'content' => 'Boshlang\'ich qiymatga qaytarish',
                    'icon' => 'check',
                    'url' => ['point-refresh'],
                    'cssClass' => 'btn btn-outline-secondary',

                ],
            ],
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>