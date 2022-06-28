
<?php
/** @var \common\models\Outcome $outcome_rulons */
/** @var \common\models\Outcome $outcome_rulons_labels */
/** @var \common\models\Outcome $outcome_products */
/** @var \common\models\Outcome $outcome_products_labels */
/** @var \common\models\Outcome $outcome_aksessuar */
/** @var \common\models\Outcome $outcome_aksessuar_labels */

use kartik\daterange\DateRangePicker;
use soft\helpers\Html;
use soft\helpers\Url;

$outcome_rulons=json_encode($outcome_rulons);
$outcome_rulons_labels=json_encode($outcome_rulons_labels);
$outcome_products=json_encode($outcome_products);
$outcome_products_labels=json_encode($outcome_products_labels);
$outcome_aksessuar=json_encode($outcome_aksessuar);
$outcome_aksessuar_labels=json_encode($outcome_aksessuar_labels);
$outcome_clients=json_encode($outcome_clients);
$outcome_clients_labels=json_encode($outcome_clients_labels);
$this->title = 'Statistika';

?>
<div class="row">
    <div class="col-md-6" style="width: 100%">
        <form action="<?= Url::to(['/statistics/range']) ?>" class="form-inline">
            <?php
            /** @var Load $model */
            echo DateRangePicker::widget([
                'name' => 'range',
                'attribute' => 'date_range',
                'presetDropdown' => true,
                'convertFormat' => true,
                'includeMonthsFilter' => true,
                'startAttribute' => 'datetime_min',
                'endAttribute' => 'datetime_max',
                'pluginOptions' => [
                    'timePickerIncrement' => 30,
                    'locale' => [
                        'format' => 'Y-m-d H:i:s'
                    ]
                ]
            ]);
            ?>
            <?= Html::submitButton('<i class="fas fa-search"></i> Qidirish', ['class' => 'btn btn-primary text-white', 'style' => 'margin-left:5px']) ?>
        </form>
    </div>
</div><br>
<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header" style="background: rgb(102, 102, 255, 1)">
                <h3 class="card-title">Eng ko'p mahsulot olgan mijozlar</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="barChart4"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"
                            width="487" height="250" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-header " style="background: rgba(0, 128, 255, 1)">
                <h3 class="card-title">Eng ko'p sotilgan rulonlar</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="barChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"
                            width="487" height="250" class="chartjs-render-monitor"></canvas>
                </div>
            </div>

        </div>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Eng ko'p sotilgan Mahsulotlar</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="barChart2"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"
                            width="487" height="250" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
        <div class="card card-success">
            <div class="card-header" style="background: rgb(102, 102, 255, 1)">
                <h3 class="card-title">Eng ko'p sotilgan Aksessuarlar</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="barChart3"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;"
                            width="487" height="250" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JS
  $(function () {
        var areaChartCanvas = $('#barChart').get(0).getContext('2d')
        var areaChartData = {
            labels  : {$outcome_rulons_labels},
            datasets: [
                {
                    label               : 'Eng ko\'p sotilgan rulonlar',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : {$outcome_rulons}
                },
             
            ]
        }
        
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0
        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
        var areaChartCanvas = $('#barChart2').get(0).getContext('2d')
        var areaChartData = {
            labels  : {$outcome_products_labels},
            datasets: [
                {
                    label               : "Eng ko'p sotilgan mahsulot",
                            backgroundColor     : 'rgba(0, 214, 0, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : {$outcome_products}
                },
            ]
        }
        var barChartCanvas = $('#barChart2').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0
        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
        
        /// chart 3
         var areaChartCanvas = $('#barChart3').get(0).getContext('2d')
        var areaChartData = {
            labels  : {$outcome_aksessuar_labels},
            datasets: [
                {
                    label               : "Eng ko'p sotilgan aksessuarlar",
                            backgroundColor     : 'rgba(102, 102, 255, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : {$outcome_aksessuar}
                },
            ]
        }
        var barChartCanvas = $('#barChart3').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0
        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
        
        //chart 4
           var areaChartCanvas = $('#barChart4').get(0).getContext('2d')
        var areaChartData = {
            labels  : {$outcome_clients_labels},
            datasets: [
                {
                    label               : "ko'p mahsulot olgan mijozlar",
                            backgroundColor     : 'rgba(102, 102, 255, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : {$outcome_clients}
                },
            ]
        }
        var barChartCanvas = $('#barChart4').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0
        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
        
    })
JS;
$this->registerJs($js);
?>
<script src="../../plugins/chart.js/Chart.min.js"></script>