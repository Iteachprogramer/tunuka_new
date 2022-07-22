<?php

use soft\helpers\ArrayHelper;

/** @var \common\models\Employees $employees */
$month = new \common\models\DayModel([
    'month' => date('m'),
    'year' => date('Y'),
]);

$days = $month->getDays();

$daysCount = count($days);

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Fixed Header Table</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-nowrap" border="1">
                    <thead>
                    <tr>
                        <th rowspan="1" style="vertical-align: middle; text-align: center">Iyul</th>
                        <th colspan="<?= $daysCount ?>" rowspan="1" style="text-align: center">
                            Кунлик бўйича ишга чиқган-чиқмаганлик тўғрисидаги белги
                        </th>
                        <th colspan="1" style="vertical-align: middle; text-align: center">
                            2022
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
                            <td><?= $value ?></td>
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