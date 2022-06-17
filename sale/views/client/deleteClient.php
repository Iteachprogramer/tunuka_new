<?php


/* @var $this \soft\web\View */
/* @var $model \backend\models\Client */

use soft\widget\ajaxcrud\CrudAsset;

$this->title = "Klientni o'chirish!";
$this->registerAjaxCrudAssets();
$this->addBreadCrumb('Klientlar', ['client/index']);
$this->addBreadCrumb($model->fulla_name);
$this->addBreadCrumb('Pul oldi berdilar tarixi');

CrudAsset::register($this);
?>

<?= $this->render('_clientMenu', ['model' => $model]) ?>

<span class="text-danger h4"><?= $model->fulla_name ?></span>
<span class="h4 text-muted"> va u bilan bog'liq barcha ma'lumotlarni o'chirish uchun quyidagi tugmani bosing!</span>
<br>
<br>
<p>
    <?= a("O'chirish", ['delete-client-all', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data-request-method' => 'post',
        'data-confirm-title' => 'Tasdiqlaysizmi?',
        'data-confirm-message' => "Siz rostdan ham ushbu klient va u bilan bog'liq barcha 
                                            ma'lumotlarni o'chirib tashlashni xoxlaysizmi?",
    ], 'trash-alt,fas') ?>
</p>