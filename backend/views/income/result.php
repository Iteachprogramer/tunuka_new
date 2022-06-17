<?php

use common\models\OutcomeItem;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sotilgan tovarlar';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
echo $this->render('info', ['model' => $model])
?>
    <div class="outcome-item-index">
        <div id="ajaxCrudDatatable">
            <?= GridView::widget([
                'id' => 'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showPageSummary' => true,
                'toolbarButtons' => [
                        'create'=>false
                ],
                'pjax' => true,
                'columns' => [
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'date',
                        'label' => 'Sana',
                        'value' => function (OutcomeItem $model) {
                            return Yii::$app->formatter->asDate($model->outcome->date,'dd.MM.yyyy');
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'income_id',
                        'label' => 'Tovar',
                        'value' => function (OutcomeItem $model) {
                            return $model->income->productType->product_name;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'person',
                        'label' => 'Kimga sotildi',
                        'value' => function (OutcomeItem $model) {
                            return $model->outcome->client->fulla_name;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'size',
                        'label' => 'O\'lchami',
                        'value' => function (OutcomeItem $model) {
                            return $model->outcome->size;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'count',
                        'label' => 'Soni',
                        'value' => function (OutcomeItem $model) {
                            return $model->outcome->count;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'total_size',
                        'label' => 'Umumiy O\'lchami',
                        'value' => function (OutcomeItem $model) {
                            return $model->outcome_size;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'cost',
                        'label' => 'Narxi',
                        'format' => 'integer',
                        'value' => function (OutcomeItem $model) {
                            return $model->outcome->cost;
                        }
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'total',
                        'label' => 'Umumiy summa',
                        'format' => 'integer',
                        'pageSummary' => true,
                        'value' => function (OutcomeItem $model) {
                            return $model->outcome->total;
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