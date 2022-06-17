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
            'label' => "Aksessuar",
            'url' => ['client/aksessuar-index', 'type_id' => ProductList::TYPE_AKSESSUAR,'id' => $client_id],
            'class' => 'active',
        ],
        [
            'label' => "Rulon",
            'url' => ['client/rulon-index', 'type_id' => ProductList::TYPE_RULON,'id' => $client_id],
        ],
        [
            'label' => "Mahsulot",
            'url' => ['client/product-index', 'type_id' => ProductList::TYPE_PRODUCT,'id' => $client_id],
        ],


    ]
]); ?>

