<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\point\models\PointSystem */
?>
<div class="point-system-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id',
            'point',
        ],
    ]) ?>

</div>
