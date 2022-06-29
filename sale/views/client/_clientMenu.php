<?php


use common\models\Client;
use soft\helpers\Html;
use soft\widget\bs4\TabMenu;

?>
<?php if ($model->client_type_id==Client::CLIENT_TYPE_CLIENT ||$model->client_type_id==Client::CLIENT_TYPE_MOUTH ):?>
    <?= TabMenu::widget([
        'items' => [
            [
                'label' => "Umumiy",
                'url' => ['client/view', 'id' => $model->id],
                'icon' => 'fas fa-info-circle'
            ],
            [
                'label' => "Pul oldi-berdi",
                'url' => ['client/accounts', 'id' => $model->id],
                'icon' => 'fas fa-dollar-sign'
            ],
            [
                'label' => "Sotilgan yuklar",
                'url' => ['outcome-group/client-outcome-group', 'id' => $model->id],
                'icon' => 'fas fa-truck',
            ],


        ]
    ]); ?>
<?php else:?>
    <?= TabMenu::widget([
        'items' => [
            [
                'label' => "Umumiy",
                'url' => ['client/view', 'id' => $model->id],
                'icon' => 'fas fa-info-circle'
            ],
            [
                'label' => "Pul oldi-berdi",
                'url' => ['client/accounts', 'id' => $model->id],
                'icon' => 'fas fa-dollar-sign'
            ],
            [
                'label' => "Oligan yuklar",
                'url' => ['client/income', 'id' => $model->id],
                'icon' => 'fas fa-truck',
            ],


        ]
    ]); ?>

<?php endif;?>
