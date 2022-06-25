<?php


use common\models\Client;
use common\models\Outcome;
use common\models\ProductList;
use soft\helpers\Html;
use soft\widget\bs4\TabMenu;

?>
<?= /** @var Outcome $model */
TabMenu::widget([
    'items' => [
        [
            'label' => "Rulon",
            'url' => ['outcome/rulons'],
        ],
        [
            'label' => "Mahsulot",
            'url' => ['outcome/product-reports'],
        ],
        [
            'label' => "Aksessuar",
            'url' => ['outcome/aksessuar-reports'],
        ],
    ]
]); ?>

