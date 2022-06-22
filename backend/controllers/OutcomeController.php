<?php

namespace backend\controllers;

use common\models\Account;
use common\models\Client;
use common\models\Income;
use common\models\OutcomeGroup;
use common\models\OutcomeItem;
use common\models\ProductList;
use soft\web\AjaxCrudController;
use Yii;
use common\models\Outcome;
use common\models\search\OutcomeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * OutcomeController implements the CRUD actions for Outcome model.
 */
class OutcomeController extends AjaxCrudController
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
     * Lists all Outcome models.
     * @return mixed
     */
    public function actionIndex()
    {
        $type_id = Yii::$app->request->get('type_id') ?? ProductList::TYPE_AKSESSUAR;
        $id = Yii::$app->request->get('id');
        $group = OutcomeGroup::findOne($id);
        if ($group) {
            $searchModel = new OutcomeSearch([
                'type_id' => $type_id,
                'group_id' => $group->id,
            ]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'group' => $group,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRulonIndex()
    {
        $type_id = Yii::$app->request->get('type_id') ?? ProductList::TYPE_RULON;
        $id = Yii::$app->request->get('id');
        $group = OutcomeGroup::findOne($id);
        $searchModel = new OutcomeSearch([
            'type_id' => $type_id,
            'group_id' => $group->id,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('rulon-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'group' => $group,
        ]);
    }

    public function actionProductIndex()
    {
        $type_id = Yii::$app->request->get('type_id');
        $id = Yii::$app->request->get('id');
        $group = OutcomeGroup::findOne($id);
        $searchModel = new OutcomeSearch([
            'type_id' => $type_id,
            'group_id' => $group->id,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('product-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'group' => $group,
        ]);
    }

    /**
     * Displays a single Outcome model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Outcome #" . $id,
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


    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->productType->type_id == ProductList::TYPE_RULON) {
            if ($request->isGet) {
                return [
                    'title' => $model->productType->product_name,
                    'content' => $this->renderAjax('rulon', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $incomes = Income::find()->andWhere(['!=', 'length', 0])->all();
                    $model->save();
                    $size = floatval($model->total_size);
                    foreach ($incomes as $income) {
                        if ($size > 0) {
                            $outcome_item_residue = OutcomeItem::find()->andWhere(['income_id' => $income->id])->andWhere(['!=', 'residue_size', 0])->one();
                            if ($outcome_item_residue) {
                                if ($outcome_item_residue >= $income->length) {
                                    $diff = $outcome_item_residue - $income->length;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $income->length;
                                    $outcome_item->residue_size = $diff;
                                    $outcome_item->save();
                                    $income->length = 0;
                                    $income->save(false);
                                } else {
                                    $diff = $income->length - $outcome_item_residue;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $outcome_item_residue;
                                    $outcome_item->residue_size = 0;
                                    $outcome_item->save();
                                    $income->length = $diff;
                                    $income->save(false);

                                }
                            } else {
                                if ($size >= $income->length) {
                                    $diff = $size - $income->length;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $income->length;
                                    $outcome_item->residue_size = $diff;
                                    $outcome_item->save();
                                    $income->length = 0;
                                    $income->save(false);
                                } else {
                                    $diff = $income->length - $size;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $size;
                                    $outcome_item->residue_size = 0;
                                    $outcome_item->save();
                                    $income->length = $diff;
                                    $income->save(false);
                                }
                            }
                            $size = $outcome_item->residue_size;
                        } else {
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
                $transaction->commit();
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true
                ];

            }
        }
        if ($model->productType->type_id == ProductList::TYPE_AKSESSUAR) {
            if ($request->isGet) {
                return [
                    'title' => $model->productType->product_name,
                    'content' => $this->renderAjax('aksessuar', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $incomes = Income::find()->andWhere(['!=', 'length', 0])->all();
                    $model->save();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
                $transaction->commit();
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true
                ];

            }
        }
        if ($model->productType->type_id == ProductList::TYPE_PRODUCT) {
            if ($request->isGet) {
                return [
                    'title' => $model->productType->product_name,
                    'content' => $this->renderAjax('product', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $incomes = Income::find()->andWhere(['!=', 'length', 0])->all();
                    $model->save();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
                $transaction->commit();
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true
                ];

            }
        }

    }

    /**
     * Delete an existing Outcome model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $outcome_items = OutcomeItem::find()->andWhere(['outcome_id' => $model->id])->all();
            if ($outcome_items) {
                foreach ($outcome_items as $outcome_item) {
                    $income = $outcome_item->income;
                    $income->length = $income->length + $outcome_item->outcome_size;
                    $income->save();
                    $outcome_item->delete();
                }
            }
            $model->delete();
        } catch (\Exception $e) {
            $transaction->rollBack();
            forbidden("Ma'lumotlarni o'chirishda xatolik yuz berdi!");
        }
        $transaction->commit();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    /**
     * Delete multiple existing Outcome model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    public function actionCreateAksessuar()
    {
        $request = Yii::$app->request;
        $group = OutcomeGroup::find()->where(['id' => $request->get('group_id')])->one();
        if ($group) {
            $model = new Outcome([
                'date' => Yii::$app->formatter->asDate('now', 'php:d-m-Y'),
                'group_id' => $group->id,
                'client_id' => $group->client_id,
            ]);
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Mahsulot",
                    'content' => $this->renderAjax('aksessuar', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit", 'tabindex' => '5'])

                ];
            } else if ($model->load($request->post()) && $model->validate()  && $model->save()) {
                if ($model->count) {
                    $model->residual = $model->productType->residual - $model->count;
                } else {
                    $model->residual = $model->productType->residual - $model->total_size;
                }
                return [
                    'title' => "Mahsulot",
                    'forceReload' => '#crud-datatable-pjax',
                    'content' => $this->renderAjax('aksessuar', [
                        'model' => new Outcome([
                            'cost' => $model->cost,
                            'group_id' => $group->id,
                            'client_id' => $group->client_id,
                            'product_type_id' => $model->productType->id,
                            'residual' => $model->residual,
                        ]),
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit", 'tabindex' => '5'])

                ];
            } else {
                return [
                    'title' => "Mahsulot",
                    'content' => $this->renderAjax('aksessuar', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        }

    }

    public function actionCreateRulon()
    {
        $request = Yii::$app->request;
        $group = OutcomeGroup::find()->where(['id' => $request->get('group_id')])->one();
        if ($group) {
            $model = new Outcome([
                'date' => Yii::$app->formatter->asDate('now', 'php:d-m-Y'),
                'group_id' => $group->id,
                'client_id' => $group->client_id,
            ]);
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Rulon",
                    'content' => $this->renderAjax('rulon', [
                        'model' => $model,

                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit", 'tabindex' => '4'])

                ];
            } else if ($model->load($request->post()) && $model->validate() && $model->save()) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $incomes = Income::find()->andWhere(['!=', 'length', 0])->andWhere(['product_type_id' => $model->productType->id])->all();
                    $size = floatval($model->total_size);
                    foreach ($incomes as $income) {
                        if ($size > 0) {
                            $outcome_item_residue = OutcomeItem::find()->andWhere(['income_id' => $income->id])->andWhere(['!=', 'residue_size', 0])->one();
                            if ($outcome_item_residue) {
                                if ($outcome_item_residue >= $income->length) {
                                    $diff = $outcome_item_residue - $income->length;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $income->length;
                                    $outcome_item->residue_size = $diff;
                                    $outcome_item->save();
                                    $income->length = 0;
                                    $income->save(false);
                                } else {
                                    $diff = $income->length - $outcome_item_residue;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $outcome_item_residue;
                                    $outcome_item->residue_size = 0;
                                    $outcome_item->save();
                                    $income->length = $diff;
                                    $income->save(false);

                                }
                            } else {
                                if ($size >= $income->length) {
                                    $diff = $size - $income->length;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $income->length;
                                    $outcome_item->residue_size = $diff;
                                    $outcome_item->save();
                                    $income->length = 0;
                                    $income->save(false);
                                } else {
                                    $diff = $income->length - $size;
                                    $outcome_item = new OutcomeItem();
                                    $outcome_item->outcome_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $size;
                                    $outcome_item->residue_size = 0;
                                    $outcome_item->save();
                                    $income->length = $diff;
                                    $income->save(false);
                                }
                            }
                            $size = $outcome_item->residue_size;
                        } else {
                            break;
                        }
                    }

                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
                $transaction->commit();
                return [
                    'title' => "Rulon",
                    'forceReload' => '#crud-datatable-pjax',
                    'content' => $this->renderAjax('rulon', [
                        'model' => new Outcome([
                            'cost' => $model->cost,
                            'group_id' => $group->id,
                            'client_id' => $group->client_id,
                            'product_type_id' => $model->productType->id,
                            'residual' => $model->productType->residual - $model->total_size,
                        ]),
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit", 'tabindex' => '4'])

                ];
            } else {
                return [
                    'title' => "Rulon",
                    'content' => $this->renderAjax('rulon', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        }

    }

    public function actionCreateProduct()
    {
        $request = Yii::$app->request;
        $group = OutcomeGroup::find()->where(['id' => $request->get('group_id')])->one();
        if ($group) {
            $model = new Outcome([
                'date' => Yii::$app->formatter->asDate('now', 'php:d-m-Y'),
                'group_id' => $group->id,
                'client_id' => $group->client_id,
            ]);

            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Mahsulot",
                    'content' => $this->renderAjax('product', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit", 'tabindex' => '5'])

                ];
            }
            else if ($model->load($request->post()) && $model->validate()  && $model->save()) {
                    if ($model->count) {
                        $model->residual = $model->productType->residual - $model->count;
                    } else {
                        $model->residual = $model->productType->residual - $model->total_size;
                    }
                    return [
                        'title' => "Mahsulot",
                        'forceReload' => '#crud-datatable-pjax',
                        'content' => $this->renderAjax('product', [
                            'model' => new Outcome([
                                'cost' => $model->cost,
                                'group_id' => $group->id,
                                'client_id' => $group->client_id,
                                'product_type_id' => $model->productType->id,
                                'residual' => $model->residual,
                            ]),
                        ]),
                        'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                            Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit", 'tabindex' => '5'])

                    ];
            } else {
                return [
                    'title' => "Mahsulot",
                    'content' => $this->renderAjax('product', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        }
    }


    public function actionProductType()
    {
        $id = Yii::$app->request->post('id');
        $product_list = ProductList::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = $product_list->sizeType->name;
        $residual = number_format($product_list->residual, 2, '.', '');
        return ['product_list' => $product_list, 'residual' => $residual, 'type' => $type];
    }

    public function actionProvider()
    {
        $id = Yii::$app->request->post('id');
        $client = Client::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $debt = number_format($client->finishAccountSum, 0, ' ', ' ');
        $debt_dollar = number_format($client->finishAccountSumDollar, 0, ' ', ' ');
        return ['debt' => $debt, 'debt_dollar' => $debt_dollar];
    }

    /**
     * Finds the Outcome model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Outcome the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Outcome::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPayment()
    {
        $group_id = Yii::$app->request->get('id');
        $group = OutcomeGroup::find()->andWhere(['id' => $group_id])->one();
        if ($group->load(Yii::$app->request->post()) && $group->validate()) {
            $group->status = OutcomeGroup::STATUS_ACTIVE;
            $group->save();
            return $this->redirect(['outcome-group/index']);
        }
        return $this->render('payment', [
            'group' => $group
        ]);
    }
}
