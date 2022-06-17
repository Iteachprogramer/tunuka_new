<?php

use common\models\Client;
use common\models\OutcomeGroup;
use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sotilgan yuklar';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>
<?=$this->render('_clientMenu',['model'=>$model])?>
<?=$this->render('info',['model'=>$model])?>
    <div class="outcome-group-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax'=>true,
                'toolbarButtons' => [
                    'create' =>
                        [
                            'url' => Url::to(['outcome-group/create']),
                            'modal' => true,
                        ],
                ],
             'columns' => [
                 [
                     'class' => '\kartik\grid\DataColumn',
                     'attribute' => 'date',
                     'format' => 'raw',
                     'value' => function (OutcomeGroup $model) {
                         return Html::a(Yii::$app->formatter->asDate($model->date, 'dd.MM.yyyy'), Url::to(['/outcome/index', 'id' => $model->id,]), ['data-pjax' => '0']);
                     }

                 ],
                 [
                     'class' => '\kartik\grid\DataColumn',
                     'attribute' => 'discount',
                 ],
                 [
                     'class' => '\kartik\grid\DataColumn',
                     'attribute' => 'total',
                 ],
                 [
                     'class' => 'kartik\grid\ActionColumn',
                     'dropdown' => false,
                     'vAlign' => 'middle',
                     'urlCreator' => function ($action, $model, $key, $index) {
                         return Url::to([$action, 'id' => $key]);
                     },
                     'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
                     'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
                     'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
                         'data-confirm' => false, 'data-method' => false,// for overide yii data api
                         'data-request-method' => 'post',
                         'data-toggle' => 'tooltip',
                         'data-confirm-title' => 'Are you sure?',
                         'data-confirm-message' => 'Are you sure want to delete this item'],
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