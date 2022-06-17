<?php

use common\models\Account;
use common\models\Client;
use kartik\daterange\DateRangePicker;
use soft\grid\GridView;
use soft\helpers\Url;
use soft\widget\ajaxcrud\CrudAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var Account $model */
$this->title = 'Kassa';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<?= $this->render('_clientMenu', ['model' => $model]) ?>
<?= $this->render('info', ['model' => $model]) ?>
<div class="account-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbarTemplate' => ' {give-money} {take-money} {refresh}',
        'showPageSummary' => true,
        'toolbarButtons' => [
            'give-money' => [
                'content' => 'Pul berish',
                'modal' => true,
                'icon' => 'arrow-up,fas',
                'cssClass' => 'btn btn-success rounded-0 mr-2',
                'url' => to(['create-account', 'id' => $model->id, 'type_id' => Account::TYPE_OUTCOME])
            ],
            'take-money' => [
                'content' => 'Pul olish',
                'modal' => true,
                'icon' => 'arrow-down,fas',
                'cssClass' => 'btn btn-info rounded-0 mr-2',
                'url' => to(['create-account', 'id' => $model->id, 'type_id' => Account::TYPE_INCOME])
            ],
        ],

        'columns' => [

            [
                'attribute' => 'type_id',
                'format' => 'raw',
                'value' => 'typeBadge',
                'filter' => Account::types(),
                'width' => '100px',
            ],
            [
                'attribute' => 'total',
                'format' => 'integer',
                'width' => '190px',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'sum',
                'width' => '160px',
                'format' => 'integer',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'dollar',
                'format' => 'integer',
                'pageSummary' => true,
            ],
            'dollar_course',
//            [
//                'attribute' => 'dollarTotal',
//                'format' => 'integer',
//                'pageSummary' => true,
//            ],
            [
                'attribute' => 'bank',
                'format' => 'integer',
            ],
            [
                'attribute' => 'date',
                'format' => 'dateUz',
                'width' => '160px',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'model' => $searchModel,
                    'convertFormat' => true,
                    'presetDropdown' => true,
                    'includeMonthsFilter' => true,
                    'pluginOptions' => [
                        'timePicker' => true,
                        'timePickerIncrement' => 30,
                        'locale' => [
                            'format' => 'Y-m-d H:i:s'
                        ]
                    ]
                ]
            ],
            'actionColumn' => [
                'urls' => [
                    'update' => function ($action, $model) {
                        return to(['update-account', 'id' => $model->id]);
                    },
                    'delete' => function ($action, $model) {
                        return to(['delete-account', 'id' => $model->id]);
                    },
                ],
                'controller' => 'account',
                'viewOptions' => [
                    'role' => 'modal-remote'
                ],
                'updateOptions' => [
                    'role' => 'modal-remote'
                ],
            ],
            ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
