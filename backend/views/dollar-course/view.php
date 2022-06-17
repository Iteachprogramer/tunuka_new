<?php

use common\models\DollarCourse;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DollarCourse */
?>
<div class="dollar-course-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'course',
            'created_at:dateTime',
            'updated_at:dateTime',
            [
                    'attribute'=>'created_by',
                    'value'=>$model->createdBy->username,
            ],
            [
                    'attribute'=>'updated_by',
                    'value'=>$model->updatedBy->username,
            ],

        ],
    ]) ?>

</div>
