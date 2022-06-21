<?php

use soft\grid\GridView;
use soft\widget\ajaxcrud\CrudAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DollarCourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dollar Kursi';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
    <div class="dollar-course-index">
        <div id="ajaxCrudDatatable">
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => true,
                'columns' => require(__DIR__ . '/_columns.php'),
                'toolbarButtons' => [
                    'create' => false,
                ],
            ]) ?>
        </div>
    </div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>