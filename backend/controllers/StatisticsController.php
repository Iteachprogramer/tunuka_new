<?php

namespace backend\controllers;

use common\models\Outcome;
use yii\filters\VerbFilter;

class StatisticsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $outcome_rulons = [];
        $outcome_rulons_labels = [];
        $outcomes=Outcome::getChartRulons();
        foreach ($outcomes as $key => $outcome) {
            $outcome_rulons[] = $outcome['total_size'];
            $outcome_rulons_labels[] = $outcome['productType']['product_name'];
        }
        return $this->render('index',[
            'outcome_rulons'=>$outcome_rulons,
            'outcome_rulons_labels'=>$outcome_rulons_labels,
        ]);
    }
}