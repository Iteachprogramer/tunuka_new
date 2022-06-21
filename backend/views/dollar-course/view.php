<?php

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
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
