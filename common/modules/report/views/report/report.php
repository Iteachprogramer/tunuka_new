<?php

use common\models\DayModel;
use common\models\Employees;
use soft\helpers\ArrayHelper;
use soft\helpers\Html;
use soft\helpers\Url;

$this->title = 'Ishchilar xisoboti';
/** @var Employees $employees */
$substr_check = substr($month->month, 0, 1);
if ($substr_check == 0) {
    $substr = substr($month->month, 1, 1);
} else {
    $substr = $month->month;
}
$month_name = ArrayHelper::getValue(DayModel::months(), $substr);
$days = $month->getDays();
$daysCount = count($days);
?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title"
                                style="text-align: center"><?= $month_name . ' ' . $month->year ?></h3>
                        </div>

                        <div class="col-md-6" style="margin-top: 20px">
                            <?= Html::beginForm(['report/list'], 'get', ['id' => 'filter-form', 'class' => 'form-inline']) ?>
                            <div class="form-group" style="width: 100%;justify-content: end">
                                <?=$month->renderPrevMonthLink()?>
                                <?= Html::dropDownList('year', $month->year, DayModel::years(), ['class' => 'form-control select']) ?>
                                <?= Html::dropDownList('month', $substr, DayModel::months(), ['class' => 'form-control select']) ?>
                                <?=$month->renderNextMonthLink()?>
                            </div>
                            <?= Html::endForm() ?>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap" border="1">
                        <thead>
                        <tr>
                            <th rowspan="1" style="vertical-align: middle; text-align: center"><?= $month_name ?></th>
                            <th colspan="<?= $daysCount ?>" rowspan="1" style="text-align: center">
                                Кунлик бўйича ишга чиқган-чиқмаганлик тўғрисидаги белги
                            </th>
                            <th colspan="1" style="vertical-align: middle; text-align: center">
                                <?= $month->year ?>
                            </th>
                        </tr>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle; text-align: center">Ходимнинг ФИШ</th>
                            <?php foreach ($days as $day): ?>
                                <?php $weekDayName = ArrayHelper::getArrayValue($day, 'weekDayName'); ?>
                                <?php $isSunday = ArrayHelper::getArrayValue($day, 'isSunday'); ?>
                                <th rowspan="1" style="text-align: center; <?= $isSunday ? 'color:red' : '' ?>">
                                    <?= $weekDayName ?>
                                </th>
                            <?php endforeach; ?>
                            <th colspan="1" rowspan="2" style="vertical-align: middle; text-align: center">
                                Jami bir oyda ish kuni
                            </th>
                        </tr>
                        <tr>
                            <?php foreach ($days as $day): ?>
                                <?php $date = ArrayHelper::getArrayValue($day, 'dayNumber'); ?>
                                <th rowspan="1" style="text-align: center;background: #381f00;color: white">
                                    <?= $date ?>
                                </th>
                            <?php endforeach; ?>

                        </tr>

                        </thead>
                        <tbody>
                        <tr>
                            <?php foreach ($employees

                            as $key => $employee): ?>
                            <?php
                            $count_employee_days = 0;
                            ?>
                            <td><?= $employee->name ?></td>
                            <?php foreach ($days as $day): ?>
                                <?php $date = ArrayHelper::getArrayValue($day, 'date'); ?>
                                <?php
                                $valueIndex = strtotime($date) . '_' . $employee->id;
                                $value = ArrayHelper::getValue($month->getValues(), [$valueIndex, 'start_day'], '');
                                ?>
                                <?php $count_employee_days += $value ? 1 : 0 ?>
                                <td style="background: <?= $value > $employee->start_day ? '#FFB266' : '' ?>"><?= $value?date('H:i',strtotime($value)):'' ?></td>
                            <?php endforeach; ?>
                            <td><?= $count_employee_days ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
<?php
$css = <<<CSS
.select {
    margin-right: 4px;
}
CSS;
$this->registerCss($css);

$js = <<<JS
    $('.select').on('change', function(){
        $('#filter-form').submit()
    })
    $('.left-table').on('click', function(){
        $('#filter-form').submit()
    })
    $('.right-table').on('click', function(){
        $('#filter-form').submit()
    })
JS;

$this->registerJs($js);