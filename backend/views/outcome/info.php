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
                'url' => ['outcome/rulon-index', 'type_id' => ProductList::TYPE_RULON,'id'=>$group->id],
            ],
            [
                'label' => "Mahsulot",
                'url' => ['outcome/product-index', 'type_id' => ProductList::TYPE_PRODUCT,'id'=>$group->id],
            ],
            [
                'label' => "Aksessuar",
                'url' => ['outcome/index', 'type_id' => ProductList::TYPE_AKSESSUAR,'id'=>$group->id],
            ],
            [
                'label' => "To'lov",
                'url' => ['outcome/payment', 'id'=>$group->id],
            ],
        ]
    ]); ?>

