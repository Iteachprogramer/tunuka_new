<?php


/* @var $this yii\web\View */
/* @var $model common\models\Employees */

use common\models\Employees;
use soft\widget\bs4\DetailView;

?>
<div class="employees-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'salary',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'is_factory',
                'format' => 'raw',
                'value' => function(Employees $model) {
                    if ($model->is_factory == Employees::IS_FACTORY_YES) {
                        return '<span class="badge badge-success">Ha</span>';
                    } else {
                        return '<span class="badge badge-danger">Yo\'q</span>';
                    }
                },
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'status',
                'format' => 'raw',
                'value' => function(Employees $model) {
                    if ($model->status == Employees::STATUS_ACTIVE) {
                        return '<span class="badge badge-success">Ishlayabdi</span>';
                    } else {
                        return '<span class="badge badge-danger">Ishlamayabdi</span>';
                    }
                },
            ],
            'created_at',
            'updated_at',
            [
                    'attribute' => 'created_by',
                    'value' => function($model) {
                        return $model->createdBy->username;
                    }
            ],
            [
                'attribute' => 'created_by',
                'value' => function($model) {
                    return $model->updatedBy->username;
                }
            ],
        ],
    ]) ?>

</div>
