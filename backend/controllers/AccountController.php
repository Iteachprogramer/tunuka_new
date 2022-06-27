<?php

namespace backend\controllers;

use common\models\Account;
use common\models\Client;
use common\models\DollarCourse;
use common\models\Employees;
use common\models\search\AccountSearch;
use soft\web\AjaxCrudController;
use soft\widget\dynamicform\DynamicFormModel;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;

class AccountController extends AjaxCrudController
{

    public $modelClass = 'common\models\Account';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['admin']
                    ],
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
    public function actionDebtClient(){
        $id = Yii::$app->request->post('id');
        $client = Client::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $debt = number_format($client->finishAccountSum, 0, ' ', ' ');
        $debt_dollar = number_format($client->finishAccountSumDollar, 0, ' ', ' ');
        return ['debt' => $debt, 'debt_dollar' => $debt_dollar];
    }
    public function actionDebtEmployee(){
        $id = Yii::$app->request->post('id');
        $employees = Employees::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $debt = number_format($employees->employeeFinishSum, 0, ' ', ' ');
        return ['debt' => $debt];
    }
    //<editor-fold desc="CRUD" defaultstate="collapsed">

    public function actionIndex()
    {
        $searchModel = new AccountSearch();
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
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->ajaxCrud->viewAction($model, ['footer' => $this->ajaxCrud->closeButton()]);
    }

    public function actionCreate($type_id)
    {
        $dollarCourse = DollarCourse::find()->orderBy(['id' => SORT_DESC])->one();
        $model = new Account([
            'type_id' => $type_id,
            'dollar_course' => $dollarCourse->course,
            'date'=>Yii::$app->formatter->asDatetime(time(), 'php:Y-m-d'),
        ]);
        $title = $model->isIncome ? 'Kassaga kirim qilish' : 'Kassadan chiqim qilish';
        return $this->ajaxCrud->createAction($model, ['title' => $title, 'returnUrl' => ['index']]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->sum = abs($model->sum);
        $model->dollar = abs($model->dollar);
        $model->bank = abs($model->bank);
        $model->date = Yii::$app->formatter->asDate($model->date, 'php:d.m.Y');
        return $this->ajaxCrud->updateAction($model, ['returnUrl' => ['index']]);
    }

    /**
     * @param $id
     * @return array|mixed|\yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\MethodNotAllowedHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->checkIfRequestMethodIsPost();

        $model = $this->findModel($id);
        if ($model->is_main) {
            forbidden("Ushbu kassa asosiy boshlang'ich kassa bo'lganligi uchun o'chirishga ruxsat berilmaydi!");
        }
        $model->delete();
        return $this->ajaxCrud->closeModalResponse();
    }

    public function actionBulkdelete()
    {

        $this->checkIfRequestMethodIsPost();
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            if (!$model->is_main) {
                $model->delete();
            }
        }
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
     * @param $id
     * @return Account
     * @throws \yii\web\NotFoundHttpException|\yii\web\ForbiddenHttpException
     */
    public function findModel($id)
    {
        /** @var Account $model */
        $model = parent::findModel($id);

        if ($model->is_main) {
            $model->scenario = 'main';
        }
        return $model;
    }

    //</editor-fold>

    public function actionCreateMultiple()
    {
        $models = [new Account()];
        $dform = new DynamicFormModel([
            'models' => $models,
            'modelClass' => Account::class,
        ]);
        if ($this->post()) {
            $date = $this->post('date', time());
            $dform->modelsAttributes = ['date' => strtotime($date)];
            $dform->loadSave();
            $this->redirect(['index']);
        }
        return $this->render('createMultiple', [
            'dform' => $dform,
        ]);
    }

}
