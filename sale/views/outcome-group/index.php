<?php
use frontend\assets\AppAsset;

use soft\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OutcomeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sotligan yukar';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<style>
    .last {
        border-bottom: 1px dashed black;
    }
    .border-solid{
        border: 1px dashed black;
        padding: 8px;
    }
    .margin{
        padding-top: 10px;
    }

</style>
<div class="outcome-group-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbarButtons' => [
                'create' =>
                    [
                        'url' => Url::to(['outcome-group/create']),
                        'modal' => true,
                    ],
            ]

        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "title" => '<h4 class="modal-title">Modal title</h4>',
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<div id="table" style="display: none" >

    <?php
    $url=Url::to(['outcome-group/check-print']);
    ?>
</div>
<input type="hidden" value="<?=$url?>" name="url_group">
<?php
$js = <<< JS
    $('.printButton').click(function (e) {
        let url = $('input[name=url_group]').val()
        var id = this.getAttribute("data-id");
        $.ajax({
            url: url, type: 'GET', data: {id: id}, success: async function (result) {
                let data = result.message
                $('#table').html(data);
                w = window.open();
                w.document.write($('#table').html());
                await new Promise(r => setTimeout(r, 2000))
                w.print();
                w.close()
            }
        })
    })
JS;
$this->registerJs($js);
?>
