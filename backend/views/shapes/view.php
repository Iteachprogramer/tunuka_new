<?php


/* @var $this yii\web\View */
/* @var $model common\models\Shapes */

use soft\widget\bs4\DetailView;

?>
<div class="shapes-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                    'attribute' => 'created_at',
                    'label' => 'Yaratilgan',
                    'format' => ['date', 'php:d-m-Y H:i:s'],
            ],
        ],
    ]) ?>

</div>
