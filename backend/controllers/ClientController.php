<?php

namespace backend\controllers;

use common\models\Account;
use common\models\Income;
use common\models\Outcome;
use common\models\OutcomeGroup;
use common\models\OutcomeItem;
use common\models\ProductList;
use common\models\search\AccountSearch;
use common\models\search\IncomeSearch;
use common\models\search\OutcomeGroupSearch;
use common\models\search\OutcomeSearch;
use soft\web\AjaxCrudController;
use Yii;
use common\models\Client;
use common\models\search\ClientSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends AjaxCrudController
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
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAksessuarIndex()
    {
        $type_id = Yii::$app->request->get('type_id') ?? ProductList::TYPE_AKSESSUAR;
        $client_id = Yii::$app->request->get('id');
        $searchModel = new OutcomeSearch([
            'type_id' => $type_id
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('outcome-index/aksessuar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'client_id' => $client_id,
        ]);
    }

    public function actionRulonIndex()
    {
        $type_id = Yii::$app->request->get('type_id');
        $client_id = Yii::$app->request->get('id');
        $searchModel = new OutcomeSearch([
            'type_id' => $type_id
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('outcome-index/rulon-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'client_id' => $client_id
        ]);
    }

    public function actionProductIndex()
    {
        $type_id = Yii::$app->request->get('type_id');
        $client_id = Yii::$app->request->get('id');
        $searchModel = new OutcomeSearch([
            'type_id' => $type_id
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('outcome-index/product-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'client_id' => $client_id
        ]);
    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => 'Klient',
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['Tahrirlash', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionViewIncome($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findIncomeModel($id);
            return [
                'title' => $model->productType->product_name,
                'content' => $this->renderAjax('view-income', [
                    'model' => $model,
                ]),
                'footer' => '',
            ];
        } else {
            return $this->render('view-income', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionUpdateIncome($id)
    {
        $model = $this->findIncomeModel($id);
        $model->date = Yii::$app->formatter->asDate($model->date, 'yyyy-MM-dd');
        $title = 'Tahrirlash';
        return $this->ajaxCrud->createAction($model, [
            'title' => 'Yuk olish',
            'view' => 'client_income_form',
            'returnUrl' => ['client/index'],
        ], ['provider' => $model->provider, 'title' => 'Yuk olish']);
    }

    /**
     * Creates a new Client model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Client();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                ];
            } else {
                return [
                    'title' => "Yangi Klient qo'shish",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarajoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        }
    }

    public function actionIncomeCreate($id)
    {
        $client = $this->findModel($id);
        $model = new Income(
            [
                'provider_id' => $client->id,
                'date' => date('Y-m-d'),
            ]
        );
        return $this->ajaxCrud->createAction($model, [
            'title' => 'Yuk olish',
            'view' => 'client_income_form',
            'returnUrl' => ['client/index'],
        ], ['provider' => $model->provider, 'title' => 'Yuk olish']);

    }

    public function actionProductType()
    {
        $id = Yii::$app->request->post('id');
        $product_list = ProductList::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $residual = number_format($product_list->residual, 2, '.', '');
        return ['product_list' => $product_list, 'residual' => $residual];
    }

    /**
     * Updates an existing Client model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::a('Tahrirlash', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Tahrirlash #" . $model->fulla_name,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        }
    }

    /**
     * Delete an existing Client model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDeleteClientAll($id)
//    {
//        $model = $this->findModel($id);
//        $incomes = $model->incomes;
//        $accounts = $model->accounts;
//        $outcomes = $model->outcome;
//        $transaction = \Yii::$app->db->beginTransaction();
//        try {
//            if ($incomes) {
//                foreach ($incomes as $income) {
//                    $income->delete();
//                }
//            }
//            if ($outcomes) {
//                foreach ($outcomes as $outcome) {
//                    $outcome->delete();
//                }
//            }
//            if ($accounts) {
//                foreach ($accounts as $account) {
//                    $account->delete();
//                }
//            }
//            $model->delete();
//            $this->setFlash('success', "Ushbu klient va u bilan bog'liq barcha ma'lumotlar o'chirib tashlandi!");
//        } catch (\Exception $e) {
//            $transaction->rollBack();
//            forbidden("Ma'lumotlarni o'chirishda xatolik yuz berdi!");
//        }
//        $transaction->commit();
//        if ($this->isAjax) {
//            $this->formatJson();
//            return ['redirect' => ['index']];
//        }
//        return $this->redirect(['index']);
//    }

    public function actionDeleteIncome($id)
    {
        $model = $this->findIncomeModel($id);
        $model->delete();
        $url = ['client'];
        if ($this->isAjax) {
            $this->formatJson();
            return $this->ajaxCrud->closeModal();
        }
        return $this->redirect($url);
    }

    /**
     * Delete multiple existing Client model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */


    public function actionIncome($id)
    {
        $model = $this->findModel($id);
        $searchModel = new IncomeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model->getIncomes());
        return $this->render('incomes', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOutcome($id)
    {
        $model = $this->findModel($id);
        $searchModel = new OutcomeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model->getOutcome());
        return $this->render('outcome', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionOutcomeGroup($id)
    {
        $model = $this->findModel($id);
        $groups=$model->getOutcomeGroups();
        $searchModel = new OutcomeGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$groups);
        return $this->render('outcome-group', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAccounts($id)
    {
        $model = $this->findModel($id);
        $searchModel = new AccountSearch([
            'client_id' => $model->id,
            'is_main' => Null,

        ]);
        $query = Account::find();
        $date = $this->request->queryParams['AccountSearch']['date'];
        $dates = explode(' - ', $date, 2);
        if (count($dates) == 2) {
            $begin = strtotime($dates[0]);
            $end = strtotime($dates[1]);
            $query->andFilterWhere(['<=', 'date', $end])
                ->andFilterWhere(['>=', 'date', $begin]);
        }
        $dataProvider = $searchModel->search($this->request->queryParams, $query);
        return $this->render('account', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateAccount($id, $type_id)
    {
        $client = $this->findModel($id);
        $model = new Account([
            'client_id' => $client->id,
            'type_id' => $type_id,
            'date'=>Yii::$app->formatter->asDatetime(time(), 'php:d.m.Y'),
        ]);

        $title = $model->isIncome ? $client->fulla_name . 'dan pul olish' : $client->fulla_name . 'ga pul berish';
        return $this->ajaxCrud->createAction($model, [
            'title' => $title,
            'view' => 'accountFormView',
            'returnUrl' => ['client/account', 'id' => $id],
        ], ['client' => $model->client, 'title' => $title]);
    }

    public function actionUpdateAccount($id)
    {
        $model = Account::findModel($id);
        $model->sum = abs($model->sum);
        $model->dollar = abs($model->dollar);
        $model->bank = abs($model->bank);

        $title = 'Tahrirlash';

//        if ($model->loadPost()){
//            dd($model->attributes);
//        }

        return $this->ajaxCrud->updateAction($model, [
            'title' => $title,
            'view' => 'accountFormView',
            'returnUrl' => ['client/account', 'id' => $id],
        ], ['client' => $model->client, 'title' => $title]);
    }

    public function actionDeleteAccount($id)
    {
        $model = $this->findAccountModel($id);
        $model->delete();
        $url = ['account', 'id' => $model->client_id];
        if ($this->isAjax) {
            $this->formatJson();
            return $this->ajaxCrud->closeModal();
        }
        return $this->redirect($url);
    }

    public function actionDeleteOutcome($id)
    {
        $model = $this->findOutcomeModel($id);
        $model->delete();
        $url = ['outcome', 'id' => $model->client_id];
        if ($this->isAjax) {
            $this->formatJson();
            return $this->ajaxCrud->closeModal();
        }
        return $this->redirect($url);
    }



    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function findIncomeModel($id)
    {
        $model = Income::findOne($id);
        if (!$model) {
            forbidden();
        }
        return $model;

    }


    private function findAccountModel($id)
    {
        $model = Account::findModel($id);
        if (!$model) {
            forbidden();
        }
        return $model;

    }


}
