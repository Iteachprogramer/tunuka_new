<?php

use soft\grid\GridView;
use soft\widget\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;

$this->title='Olingan yuklar';
/* @var $this \yii\web\View */
/* @var $model \common\models\Client */
/* @var $searchModel \common\models\search\ClientSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = 'Olingan yuklar';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=$this->render('_clientMenu',['model'=>$model])?>
<?=$this->render('info',['model'=>$model])?>

   <?php CrudAsset::register($this);

    ?>
    <div class="income-index">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showPageSummary' => true,
                'toolbarButtons' => [
                    'create' => [
                        'pjax' => true,
                        'modal' => true,
                        'url' => \soft\helpers\Url::to(['client/income-create','id'=>$model->id]),
                        'cssClass' => 'btn btn-outline-secondary',
                        'icon' => 'plus',
                        'title' => Yii::t('site', 'Create a new'),
                    ],
                ],
                'pjax'=>true,
                'columns' => require(__DIR__.'/columns_income.php'),
            ])?>
        </div>
    </div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>