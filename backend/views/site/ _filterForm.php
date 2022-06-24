<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 02.07.2021, 15:25
 */

use common\models\Client;
use soft\helpers\ArrayHelper;
use soft\helpers\Html;

/* @var $this \soft\web\View */
$sorts = [
    'haqdor' => "Haqdorlar",
    'qarzdor' => "Qarzdorlar",
];

$currentSort = Yii::$app->request->get('sort');

?>

<?= Html::beginForm(['site/index'], 'get', ['id' => 'client_filter_form']) ?>

<div class="row">
    <div class="col-sm-6">
        <div class="btn-group mb-3">
            <?= Html::dropDownList('sort', $currentSort, $sorts, [
                'class' => 'btn btn-default dropdown-toggle pl-0 pr-0',
                'id' => 'client_type_select',
                'prompt' => "Boshlang'ich",
            ]) ?>
            <button class="btn btn-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
            <a class="btn btn-danger" href="<?= to(['site/index']) ?>" id="reset_filter_button">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </div>
</div>

<?= Html::endForm() ?>
