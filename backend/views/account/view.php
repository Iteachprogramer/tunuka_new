<?php

use soft\widget\bs4\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Account */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client.fulla_name',
            'typeBadge:raw',
            'sum:integer',
            'dollar:integer',
            'dollar_course',
            'bank:integer',
            'dollarTotal:integer',
            'total:integer',
            'comment',
            'expense_type_id',
            'created_at',
            'updated_at',
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return $model->createdBy->username;
                }
            ],
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    return $model->updatedBy->username;
                }
            ],
            'date:date',
        ],
    ]) ?>

</div>
