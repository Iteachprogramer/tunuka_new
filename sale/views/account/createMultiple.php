<?php


/* @var $this \soft\web\View */
/* @var $dform \soft\widget\dynamicform\DynamicFormModel */

$this->title = "Kirim chiqim qo'shish";
$this->addBreadCrumb('Kassa', ['index']);
$this->addBreadCrumb($this->title);

?>

<?= $this->render('_multipleForm', [
    'dform' => $dform
]) ?>
