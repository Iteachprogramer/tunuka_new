<?php

use soft\grid\GridView;
use soft\widget\ajaxcrud\CrudAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;

use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klientlar';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="client-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
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