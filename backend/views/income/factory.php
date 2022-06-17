<?php

use common\models\MakeProductItem;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MakeProductItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ishlab chiqarildi';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
echo $this->render('info', ['model' => $model])
?>
    <div class="make-product-item-index">
        <div id="ajaxCrudDatatable">
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => true,
                'showPageSummary' => true,
                'toolbarButtons' => [
                    'create' => false,
                ],
                'columns' => [
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'date',
                        'label' => 'Sana',
                        'value' => function (MakeProductItem $model) {
                            return Yii::$app->formatter->asDate($model->make->date,'dd.MM.yyyy');
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'income_id',
                        'label' => 'Tovar',
                        'width' => '150px',
                        'value' => function (MakeProductItem $model) {
                            return $model->income->productType->product_name;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'make_id',
                        'label' => 'Hodim',
                        'value' => function (MakeProductItem $model) {
                            return $model->make->employee->name;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'size',
                        'label' => 'Ishlatilgan tovar',
                        'value' => function (MakeProductItem $model) {
                            return $model->outcome_size;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'Tayor mahsulot',
                        'value' => function(MakeProductItem $model){
                         return $model->make->produced->product_name;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'Ishlab chiqildi',
                        'value' => function(MakeProductItem $model){
                            return $model->make->factory_size;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => '1 metr usluga',
                        'format' => 'integer',
                        'value' => function(MakeProductItem $model){
                            return $model->make->per_metr_expence;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => '1 metr tannarxi',
                        'format' => 'integer',
                        'value' => function(MakeProductItem $model){
                            return $model->make->per_metr_cost;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'Usluga summasi',
                        'format' => 'integer',
                        'pageSummary' => true,
                        'value' => function(MakeProductItem $model){
                            return $model->make->total_expence;
                        }
                    ],
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