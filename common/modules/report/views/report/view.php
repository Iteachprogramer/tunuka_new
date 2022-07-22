<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\report\models\Report */
?>
<div class="report-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'employee_id',
            'date',
            'work_time',
            'start_day',
            'end_day',
        ],
    ]) ?>

</div>
