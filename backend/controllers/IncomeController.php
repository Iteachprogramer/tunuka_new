<?php

namespace backend\controllers;

use common\models\Client;
use common\models\OutcomeGroup;
use common\models\OutcomeItem;
use common\models\ProductList;
use common\models\search\MakeProductItemSearch;
use common\models\search\OutcomeItemSearch;
use Yii;
use common\models\Income;
use common\models\search\IncomeSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * IncomeController implements the CRUD actions for Income model.
 */
class IncomeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-account' => ['POST'],
                ]
            ]
        ];
    }


    /**
     * Lists all Income models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IncomeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Income model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => $model->productType->product_name,
                'content' => $this->renderAjax('view', [
                    'model' => $model
                ]),
                'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['Tahririlash', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Income model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Income([
            'date' => date('Y-m-d'),
        ]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load($request->post()))

        {
            $model->total = -1 * floatval($model->cost * $model->weight);
            $model->unity_type_id = $model->productType->sizeType->id;
            $model->save();
            $product = ProductList::findOne($model->product_type_id);
            if ($model->productType->type_id == ProductList::TYPE_AKSESSUAR) {
                $product->selling_price_usd = $model->cost;
            } else {
                $product->selling_price_usd = $model->price_per_meter;
            }
            $product->save(false);
            return [
                'forceReload' => '#crud-datatable-pjax',
                'forceClose' => true,
            ];
        }
        return [
            'title' => "Yangi yuk olish",
            'content' => $this->renderAjax('create', [
                'model' => $model,
            ]),
            'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit", 'tabindex' => '7'])

        ];

    }

    /**
     * Updates an existing Income model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->date = Yii::$app->formatter->asDate($model->date, 'yyyy-MM-dd');;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Tahrirlash#" . $model->productType->product_name,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) ) {
                $model->total = -1 * floatval($model->cost * $model->weight);
                $model->unity_type_id = $model->productType->sizeType->id;
                $model->save();
                $product = ProductList::findOne($model->product_type_id);
                if ($model->productType->type_id == ProductList::TYPE_AKSESSUAR) {
                    $product->selling_price_usd = $model->cost;
                } else {
                    $product->selling_price_usd = $model->price_per_meter;
                }
                $product->save(false);
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => $model->productType->product_name,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::a('Tahrirlash', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Tahrirlash #" . $model->productType->product_name,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    function actionProductType()
    {
        $id = Yii::$app->request->post('id');
        $product_list = ProductList::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $residual = number_format($product_list->residual, 2, '.', '');
        return ['product_list' => $product_list, 'residual' => $residual];
    }

    function actionProvider()
    {
        $id = Yii::$app->request->post('id');
        $client = Client::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $debt = $client->finishAccountSum;
        $debt_dollar = number_format($client->finishAccountSumDollar, 2, '.', ' ');
        return ['debt' => $debt, 'debt_dollar' => $debt_dollar];
    }

    /**
     * Delete an existing Income model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model=$this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $outcome=OutcomeItem::find()->andWhere(['income_id'=>$id])->all();
            if (!$outcome){
                $model->delete();
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            else{
               return [
                   'title' => "Xatolik",
                   'content' => "Bu qiymatni o'chirishga ruxsat etmagan. Siz ustida qiymatdan o'chirishga ruxsat etilgan qiymatlar mavjud.",
                     'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]),
               ];
            }

        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing Income model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['index']);
        }

    }

    public function actionResult()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        $outcome_items = $model->getOutcomeItems();
        $searchModel = new OutcomeItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $outcome_items);
        return $this->render('result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionFactory()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        $factories = $model->getFactories();
        $searchModel = new MakeProductItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $factories);
        return $this->render('factory', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    public function actionIncomesReport()
    {
        $date = Yii::$app->request->get('range');
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($date)) {
            $dates = explode(' - ', $date, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $incomes = Income::find()->andWhere(['type_id' => ProductList::TYPE_RULON])
                    ->andFilterWhere(['>=', 'income.date', $begin])
                    ->andFilterWhere(['<', 'income.date', $end])
                    ->all();
                if (Yii::$app->request->isAjax) {
                    $result['message'] = $this->renderAjax('rulons-report-table', ['model' => $outcome,]);
                    return $this->asJson($result);
                }
                $result = [];
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Income model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Income the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    function findModel($id)
    {
        if (($model = Income::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
