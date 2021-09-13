<?php

use backend\modules\usermanager\models\User;
use common\models\Branch;

/* @var $this soft\web\View */
/* @var $searchModel backend\modules\usermanager\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Xodimlar';
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
$branches_map = map(Branch::find()->all(), 'id', 'name');
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}',
    'toolbarButtons' => [
        'create' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-info',
            'content' => "Yangi qo'shish",
            'icon' => 'user-plus,fas'
        ]
    ],
    'cols' => [
        'username',
        'firstname',
        'lastname',
        [
            'attribute' => 'type_id',
            'format' => 'raw',
            'value' => 'typeName',
            'filter' => User::types()
        ],
        [
            'attribute' => 'branch_id',
            'format' => 'raw',
            'value' => 'branch.name',
            'label' => 'Filial nomi',
            'filter' => $branches_map,
        ],
        [
            'attribute' => 'status',
            'filter' => User::statuses(),
            'format' => 'raw',
            'value' => function ($model) {
                /** @var User $model */
                return $model->statusBadge;
            }
        ],
        'created_at',
//        'updated_at',
        'actionColumn',
    ],
]); ?>
    