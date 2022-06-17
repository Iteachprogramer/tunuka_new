<?php

use common\models\Client;
use soft\widget\bs4\DetailView;
$this->title=$model->fulla_name;
/* @var $this yii\web\View */
/* @var $model common\models\Client */
?>
<?=$this->render('_clientMenu',['model'=>$model])?>
<?=$this->render('info',['model'=>$model])?>
<?=$this->render('content',['model'=>$model])?>