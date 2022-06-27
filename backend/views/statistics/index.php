
<?php
/** @var \common\models\Outcome $outcome_rulons */
/** @var \common\models\Outcome $outcome_rulons_labels */
$outcome_rulons=json_encode($outcome_rulons);
$outcome_rulons_labels=json_encode($outcome_rulons_labels);
?>
<div class="row">

    <div class="col-md-12">

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>
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
    })
JS;
$this->registerJs($js);
?>
<script src="../../plugins/chart.js/Chart.min.js"></script>