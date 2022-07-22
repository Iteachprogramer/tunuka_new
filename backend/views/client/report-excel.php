<?php


/* @var $this \yii\web\View */
/* @var $model array|\common\models\Client[]|\yii\db\ActiveRecord[] */
?>
            <table border="1" cellspacing="0" cellpadding="3" id="myTable"
                   style="text-align: center; align-items: center;display: none;width: 100%!important;"
                   class="table table-bordered table-striped">
                <tr>
                    <td colspan="5" style="vertical-align: middle; text-align: center"> Xaqdorlar va qarizdorlar
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="vertical-align: middle; text-align: left">Sana:</td>
                    <td colspan="3"
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
                $clients = $model;
                ?>
                <?php foreach ($clients as $key => $client): ?>
                    <?php if (($client->finishAccountSum != 0) || ($client->finishAccountSumDollar != 0)): ?>
                        <tr>
                            <td style="vertical-align: middle; text-align: left"><?= $client->fulla_name ?></td>
                            <td style="vertical-align: middle; text-align: left">
                                <?php
                                if ($client->finishAccountSum > 0) {
                                    echo "<span style='color: red'>".as_integer($client->finishAccountSum)."</span>";
                                } else {
                                    echo '0';
                                }
                                ?>
                            </td>
                            <td style="vertical-align: middle; text-align: left">
                                <?php
                                if ($client->finishAccountSumDollar > 0) {
                                    echo "<span style='color: red'>".number_format($client->finishAccountSumDollar, 3, '.', ' ')."</span>";
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

