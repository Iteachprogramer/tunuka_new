<?php

use common\models\Client;
use kartik\daterange\DateRangePicker;
use soft\grid\GridView;
use soft\widget\ajaxcrud\CrudAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klientlar';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<a id="downloadLink" onclick="exportF(this)" class="btn btn-primary fa fa-file-excel-o"
   style="margin-bottom: 15px;padding: 10px"> Hisobot olish</a>

<div class="client-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'pagerDropDown' => true,
            'exportButton' => false,
            'pjax' => true,
            'toolbarButtons' => [
                'create' => [
                    'pjax' => false,
                    'modal' => true,
                    'url' => \soft\helpers\Url::to(['create']),
                    'cssClass' => 'btn btn-outline-secondary',
                    'icon' => 'plus',
                    'title' => Yii::t('site', 'Create a new'),
                ],
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => require(__DIR__ . '/_columns.php'),
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer" => "",// always need it for jquery plugin
]) ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table border="1" cellspacing="0" cellpadding="3" id="myTable"
                   style="text-align: center; align-items: center;display: none;width: 100%!important;"
                   class="table table-bordered table-striped">
                <tr>
                    <td colspan="6" style="vertical-align: middle; text-align: center"> Xaqdorlar va qarizdorlar</td>
                </tr>
                <tr>
                    <td colspan="2" style="vertical-align: middle; text-align: left">Sana:</td>
                    <td colspan="4"
                        style="vertical-align: middle; text-align: left"><?= Yii::$app->formatter->asDate(time(), 'php:d.m.Y') ?></td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; text-align: left">Mijoz nomi</td>
                    <td style="vertical-align: middle; text-align: left">Qarzi so'mda</td>
                    <td style="vertical-align: middle; text-align: left">Qarzi dollarda</td>
                    <td style="vertical-align: middle; text-align: left">Xaqqi so'mda</td>
                    <td style="vertical-align: middle; text-align: left">Xaqqi dollarda</td>
                </tr>
                <?php
                $clients = Client::find()->all();
                ?>
                <?php foreach ($clients as $key => $client): ?>
                    <?php if (($client->finishAccountSum != 0) || ($client->finishAccountSumDollar)): ?>
                        <tr>
                            <td style="vertical-align: middle; text-align: left"><?= $client->fulla_name ?></td>
                            <td style="vertical-align: middle; text-align: left">
                                <?php
                                if ($client->finishAccountSum > 0) {
                                    echo as_integer($client->finishAccountSum);
                                } else {
                                    echo '0';
                                }
                                ?>
                            </td>
                            <td style="vertical-align: middle; text-align: left">
                                <?php
                                if ($client->finishAccountSumDollar > 0) {
                                    echo number_format($client->finishAccountSumDollar, 3, '.', ' ');
                                } else {
                                    echo '0';
                                }
                                ?>
                            </td>
                            <td style="vertical-align: middle; text-align: left">
                                <?php
                                if ($client->finishAccountSum < 0) {
                                    echo as_integer($client->finishAccountSum);
                                } else {
                                    echo '0';
                                }
                                ?>
                            </td>
                            <td style="vertical-align: middle; text-align: left">
                                <?php
                                if ($client->finishAccountSumDollar < 0) {
                                    echo number_format($client->finishAccountSumDollar, 3, '.', ' ');
                                } else {
                                    echo '0';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php Modal::end(); ?>
<?php
$js = <<<JS
        function exportF(elem) {
        var table = document.getElementById("myTable");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Mijozlar.xls"); // Choose the file name
        return false;
    }
JS;
$this->registerJs($js, View::POS_HEAD);
?>
