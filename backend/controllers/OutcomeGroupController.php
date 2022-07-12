<?php

namespace backend\controllers;

use common\models\Account;
use common\models\Client;
use common\models\MakeProduct;
use common\models\MakeProductItem;
use common\models\Outcome;
use common\models\OutcomeItem;
use common\models\ProductList;
use soft\helpers\Url;
use soft\web\AjaxCrudController;
use Yii;
use common\models\OutcomeGroup;
use common\models\search\OutcomeGroupSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * OutcomeGroupController implements the CRUD actions for OutcomeGroup model.
 */
class OutcomeGroupController extends AjaxCrudController
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


    public function actionIndex()
    {
        $searchModel = new OutcomeGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionClientOutcomeGroup()
    {
        $id = Yii::$app->request->get('id');
        $date = Yii::$app->request->get('OutcomeGroupSearch')['date'];
        $client = Client::findOne($id);
        $searchModel = new OutcomeGroupSearch([
            'client_id' => $client->id
        ]);
        if ($client) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('client-group', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'client_id' => $client->id,
                'date' => $date,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    public function actionClientReports()
    {
        $date = Yii::$app->request->get('range');
        $client_id = Yii::$app->request->get('client_id');
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($date)) {
            $dates = explode(' - ', $date, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime(strtotime($dates[1]));
                $group = OutcomeGroup::find()
                    ->andWhere(['client_id' => $client_id])
                    ->andFilterWhere(['>=', 'date', $begin])
                    ->andFilterWhere(['<', 'date', $end])
                    ->all();
                if (Yii::$app->request->isAjax) {
                    $result['message'] = $this->renderAjax('table', ['groups' => $group,'date'=>$date,'client_id'=>$client_id]);
                    return $this->asJson($result);
                }
                $result = [];
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "OutcomeGroup #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new OutcomeGroup([
            'date' => Yii::$app->formatter->asDatetime(time(), 'php:d.m.Y H:i:s'),
        ]);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model->load($request->post())) {
            if ($model->phone_client_id && !$model->client_id) {
                $model->client_id = $model->phone_client_id;
            }
            $model->save();
            return [
                'forceReload' => '#crud-datatable-pjax',
                'forceClose' => true,
            ];
        } else {
            return [
                'title' => "Yangi qo'shish",
                'content' => $this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                    Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

            ];
        }
    }

    public function actionCash()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        $model = new Account([
            'date' => Yii::$app->formatter->asDate(time(), 'php:Y-m-d'),
            'client_id' => $model->client_id,
            'group_id' => $model->id,
            'type_id' => Account::TYPE_INCOME,
        ]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load($request->post()) && $model->save()) {
            return [
                'forceReload' => '#crud-datatable-pjax',
                'forceClose' => true,
            ];
        } else {
            return [
                'title' => "Kassa",
                'content' => $this->renderAjax('cash', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                    Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

            ];
        }
    }

    public function actionCreateClientOutcome()
    {
        $request = Yii::$app->request;
        $client_id = Yii::$app->request->get('client_id');
        if ($client_id) {
            $model = new OutcomeGroup([
                'date' => Yii::$app->formatter->asDate(time(), 'dd.MM.yyyy H:i:s'),
                'client_id' => $client_id
            ]);
            return $this->ajaxCrud->createAction($model, [
                'view' => 'client-group-create',
            ]);
        }

    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->date = Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i:s');

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update OutcomeGroup #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                ];
            } else {
                return [
                    'title' => "Update OutcomeGroup #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionCheckPrint()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = [];
        if (Yii::$app->request->isAjax) {
            $result['message'] = $this->renderAjax('test-print', ['model' => $model, 'aksessuar_sum' => 0, 'product_sum' => 0]);
            return $this->asJson($result);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $outcomes = Outcome::find()->andWhere(['group_id' => $model->id])->all();
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($outcomes as $outcome) {
                if ($outcomes) {
                    $outcome_items = OutcomeItem::find()->andWhere(['outcome_id' => $outcome->id])->all();
                    if ($outcome_items) {
                        foreach ($outcome_items as $outcome_item) {
                            $income = $outcome_item->income;
                            $income->length = $income->length + $outcome_item->outcome_size;
                            $income->save();
                            $outcome_item->delete();
                        }
                    }
                    $outcome->delete();
                }
            }
            $model->delete();
        } catch (\Exception $e) {
            forbidden($e->getMessage());
        }
        $transaction->commit();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        }
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            return $this->redirect(['index']);
        }


    }

    public function actionExcel()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $result = [];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $result['message'] = $this->renderAjax('excel', ['model' => $model]);
            return $this->asJson($result);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionBulkdelete()
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

    public function findModel($id)
    {
        if (($model = OutcomeGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
