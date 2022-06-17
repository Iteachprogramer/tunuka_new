<?php


use common\models\Client;
use common\models\Outcome;
use common\models\ProductList;
use soft\helpers\Html;
use soft\widget\bs4\TabMenu;

?>
<?= /** @var \common\models\Income $model */
TabMenu::widget([
    'items' => [
        [
            'label' => "Sotilgan tovar",
            'url' => ['income/result','id'=>$model->id],
        ],
        [
            'label' => "Ishlab chiqildi",
            'url' => ['income/factory', 'id'=>$model->id],
        ],
    ]
]); ?>

