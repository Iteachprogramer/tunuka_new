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
        $outcome_products = [];
        $outcome_products_labels = [];
        $outcome_aksessuar = [];
        $outcome_aksessuar_labels = [];
        $outcomes=Outcome::getChartRulons();
        $outcome_products_arr=Outcome::getChartProducts();
        $outcome_aksessuar_arr=Outcome::getChartAksessuar();
        foreach ($outcome_aksessuar_arr as $key => $outcome_aksessuar_arr_item) {
            $outcome_aksessuar[]=$outcome_aksessuar_arr_item['count'];
            $outcome_aksessuar_labels[]=$outcome_aksessuar_arr_item['productType']['product_name'];
        }
        foreach ($outcome_products_arr as $key => $outcome_product_arr) {
            $outcome_products_labels[] =$outcome_product_arr['productType']['product_name'];
            $outcome_products[] = $outcome_product_arr['total_size'];
        }
        foreach ($outcomes as $key => $outcome) {
            $outcome_rulons[] = $outcome['total_size'];
            $outcome_rulons_labels[] = $outcome['productType']['product_name'];
        }
        return $this->render('index',[
            'outcome_rulons'=>$outcome_rulons,
            'outcome_rulons_labels'=>$outcome_rulons_labels,
            'outcome_products'=>$outcome_products,
            'outcome_products_labels'=>$outcome_products_labels,
            'outcome_aksessuar'=>$outcome_aksessuar,
            'outcome_aksessuar_labels'=>$outcome_aksessuar_labels,
        ]);
    }
}