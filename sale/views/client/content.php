<?php
/** @var Client $model */

use common\models\Client;

?>

<?php if ($model->client_type_id == Client::CLIENT_TYPE_PROVIDER):?>
<div class="row">
    <div class="col-md-12 col-sm-6 col-12">
        <div class="info-box">
            <div class="info-box-content">
                <h5 align="center">Yuk oldi-berdilari</h5>
                <table class="table table-sm table-condensed table-bordered table-striped">
                    <tr>
                        <th style="width: 50%;">#</th>
                        <th>Yuk miqdori</th>
                        <th>Summa dollarda</th>
                    </tr>
                    <tr>
                        <td>Jami olingan yuk tona:</td>
                        <th>
                            <?=number_format($model->incomesCountWeight,2,'.',' ')?> tona
                        </th>
                        <th><?=$model->incomesCountWeightSum ? number_format($model->incomesCountWeightSum,3,'.',' ').' $':0?></th>
                    </tr>
                    <tr>
                        <td>Jami olingan yuk kg:</td>
                        <th>
                            <?=number_format($model->incomesCountKg,2,'.',' ')?> Kg
                        </th>
                        <th><?=$model->incomesCountKgSum ? number_format($model->incomesCountKgSum,3,'.',' ').' $':0?></th>
                    </tr>
                    <tr>
                        <td>Jami olingan yuk Dona:</td>
                        <th>
                            <?=$model->incomesCountNumer?> Dona
                        </th>
                    </tr>
                    <tr class="table-warning">
                        <th colspan="2">Umumiy:</th>
                        <th><?=number_format($model->getIncomesSum(),3,'.',' ').' $'?></th>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.info-box -->
    </div>
</div>
<?php else:?>
    <div class="row">
        <div class="col-md-12 col-sm-6 col-12">
            <div class="info-box">
                <div class="info-box-content">
                    <h5 align="center">Yuk oldi-berdilari</h5>
                    <table class="table table-sm table-condensed table-bordered table-striped">
                        <tr>
                            <th style="width: 50%;">#</th>
                            <th>Yuk miqdori</th>
                        </tr>
                        <tr>
                            <td>Jami sotilgan yuk metrda:</td>
                            <th>
                               <?=$model->outcomeCountMetr ? number_format($model->outcomeCountMetr,2,'.',' '):0?>
                            </th>
                        </tr>
                        <tr>
                            <td>Jami sotilgan yuk kg:</td>
                            <th>
                                <?=$model->outcomeCountKg ? number_format($model->outcomeCountKg,2,'.',' '):0?>
                            </th>
                        </tr>
                        <tr>
                            <td>Jami sotilgan yuk Dona:</td>
                            <th>
                                <?=number_format($model->outcomeCountNumer,2,'.',' ') ?? 0?>
                            </th>
                        </tr>
                        <tr class="table-warning">
                            <th colspan=1">Umumiy summa</th>
                            <th><?=$model->getOutcomeSum()?></th>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.info-box -->
        </div>
    </div>
<?php endif;?>