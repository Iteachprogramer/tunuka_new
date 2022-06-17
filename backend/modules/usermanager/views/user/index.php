<?php

use backend\modules\usermanager\models\User;
use common\models\Category;
use soft\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var \common\models\User $dataProvider */
/** @var \common\models\User $searchModel */
$this->title = 'Foydalanuvchilar';
$this->params['breadcrumbs'][] = $this->title;
?>

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'options' => [
                'class' => 'table-sm'
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'username',
                 [
                     'attribute'=>'fullName',
                     'value' => function ($model) {
                         return $model->firstname . ' ' . $model->lastname;
                     }
                 ],
                [
                    'attribute' => 'type_id',
                    'format' => 'raw',
                    'filter' => User::types(),
                    'value' => function (User $model) {
                        if ($model->type_id == User::TYPE_ADMIN) {
                            return '<span class="badge badge-danger">' . 'Admin' . '</span>';
                        } elseif ($model->type_id == User::TYPE_SALE) {
                            return '<span class="badge badge-success">' . 'Sotuvchi' . '</span>';
                        } elseif ($model->type_id == User::TYPE_FACTORY) {
                            return '<span class="badge badge-warning">' . 'Ishlab chiqarish' . '</span>';
                        }
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return date('d.m.Y', $data->created_at);
                    }
                ],
//        'updated_at',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'width' => '120px',
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
