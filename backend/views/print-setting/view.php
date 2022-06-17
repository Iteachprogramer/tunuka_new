<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PrintSetting */
?>
<div class="print-setting-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'width',
            'created_at',
            'updated_at',
            'updated_by',
            'created_by',
            'status',
        ],
    ]) ?>

</div>
