<?php

use common\models\Account;
use common\models\Client;
use common\models\Employees;
use soft\grid\GridView;
use soft\helpers\ArrayHelper;
use soft\helpers\Url;
use soft\widget\ajaxcrud\CrudAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kassa';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<?= $this->render('_totalAccountBoxes', ['allClients' => $allClients]) ?>
<div class="account-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,
        'toolbarButtons' => [
            'create' => [
                'pjax' => false,
                'modal' => false,
                'url' => Url::to(['account/create-multiple']),
                'cssClass' => 'btn btn-outline-secondary',
                'icon' => 'plus',
            ],
        ],
        'columns' => [
//           / ['class' => 'yii\grid\SerialColumn'],
            //  'id',
            [
                'attribute' => 'client_id',
                'format' => 'raw',
                'width' => '200px',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => Client::getMap(),
                    'options' => [
                        'placeholder' => 'Klientni tanlang...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
                'value' => function (Account $model) {
               if ($model->expenseType->name){
                   return $model->expenseType->name;
               }
               elseif ($model->is_main){
                   return 'Asosiy boshlang\'ich kassa';
               }
               else{
                   return $model->client->fulla_name;
               }
                }
            ],
            [
                'attribute' => 'employee_id',
                'format' => 'raw',
                'width' => '120px',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => ArrayHelper::map(Employees::find()->andWhere(['status'=> Employees::STATUS_ACTIVE])->all(),'id','name'),
                    'options' => [
                        'placeholder' => 'Ishchini tanlang...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ],
                'value' => function (Account $model) {
                        return $model->employee->name;
                }
            ],

            [
                'attribute' => 'type_id',
                'format' => 'raw',
                'value' => 'typeBadge',
                'filter' => Account::types(),
                'width' => '100px',
            ],
            [
                'attribute' => 'expense_type_id',
                'value' => function ($model) {
                    return $model->expenseType->name ?? '';
                },
                'format' => 'raw',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => \common\models\ExpenseType::getMapExpense(),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'placeholder' => 'Rasxodni tanlang...'
                    ]
                ]
            ],
            [
                'attribute' => 'date',
                'width' => '160px',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                            'model' => $searchModel,
                            'convertFormat' => true,
                            'presetDropdown' => true,
                            'includeMonthsFilter' => true,
                            'pluginOptions' => [
                                'locale' => [
                                    'format' => 'd.m.Y'
                                ]
                            ]
                        ],
                'value' => function(Account $model){
                    return Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y');
                },
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
                'width' => '120px',
                'pageSummary' => true,
            ],
//            'dollar_course',
//            [
//                'attribute' => 'dollarTotal',
//                'format' => 'integer',
//                'pageSummary' => true,
//            ],
//            [
//                'attribute' => 'bank',
//                'width' => '160px',
//                'format' => 'integer',
//            ],
            [
                'class' => 'soft\grid\ActionColumn',
                'width' => '120px',
                'template' => '{update} {delete}',
                'updateOptions' => [
                    'role' => 'modal-remote'
                ],
                'viewOptions' => [
                    'role' => 'modal-remote'
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
