<?php

namespace backend\controllers;

use common\models\Income;
use common\models\MakeProductItem;
use common\models\ProductList;
use Yii;
use common\models\MakeProduct;
use common\models\search\MakeProductSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * MakeProductController implements the CRUD actions for MakeProduct model.
 */
class MakeProductController extends Controller
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
     * Lists all MakeProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MakeProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single MakeProduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "MakeProduct #" . $id,
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

    /**
     * Creates a new MakeProduct model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new MakeProduct();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Yangi mahsulot ishlab chiqarish",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal",'tabindex'=>'-1']) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit",'tabindex'=>'5'])

                ];
            } else if ($model->load($request->post()) && $model->validate()) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $model->save();
                    $incomes = Income::find()->andWhere(['!=', 'length', 0])->andWhere(['product_type_id' => $model->product->id])->all();
                    $size = floatval($model->size);
                    foreach ($incomes as $income) {
                        if ($size > 0) {
                            $make_product_item = MakeProductItem::find()->andWhere(['income_id' => $income->id])->andWhere(['!=', 'residue_size', 0])->one();
                            if ($make_product_item) {
                                if ($make_product_item >= $income->length) {
                                    $diff = $make_product_item - $income->length;
                                    $outcome_item = new MakeProductItem();
                                    $outcome_item->make_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $income->length;
                                    $outcome_item->residue_size = $diff;
                                    $outcome_item->save();
                                    $income->length = 0;
                                    $income->save(false);
                                } else {
                                    $diff = $income->length - $make_product_item;
                                    $outcome_item = new MakeProductItem();
                                    $outcome_item->make_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $make_product_item;
                                    $outcome_item->residue_size = 0;
                                    $outcome_item->save();
                                    $income->length = $diff;
                                    $income->save(false);
                                }
                            }
                            else {
                                if ($size >= $income->length) {
                                    $diff = $size - $income->length;
                                    $outcome_item = new MakeProductItem();
                                    $outcome_item->make_id = $model->id;
                                    $outcome_item->income_id = $income->id;
                                    $outcome_item->outcome_size = $income->length;
                                    $outcome_item->residue_size = $diff;
                                    $outcome_item->save();
                                    $income->length = 0;
                                    $income->save(false);
                                }
                                else {

                                    $diff = $income->length - $size;
                                    $make_product_item = new MakeProductItem();
                                    $make_product_item->make_id = $model->id;
                                    $make_product_item->income_id = $income->id;
                                    $make_product_item->outcome_size = $size;
                                    $make_product_item->residue_size = 0;
                                    $make_product_item->save();
                                    $income->length = $diff;
                                    $income->save(false);
                                }
                            }
                            $size = $make_product_item->residue_size;
                        } else {
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return [
                        'content' => $e->getMessage(),
                    ];
                }
                $transaction->commit();
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                ];
            } else {
                return [
                    'title' => "Yangi mahsulot ishlab chiqarish",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing MakeProduct model.
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
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update MakeProduct #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "MakeProduct #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update MakeProduct #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
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

    /**
     * Delete an existing MakeProduct model.
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
            $makes = MakeProductItem::find()->andWhere(['make_id' => $model->id])->all();
            if ($makes){
                foreach ($makes as $make) {
                    $income = $make->income;
                    $income->length = $income->length + $make->outcome_size;
                    $income->save();
                    $make->delete();
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
            return $this->redirect(['index']);
        }


    }

    /**
     * Delete multiple existing MakeProduct model.
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
    public function actionProductType()
    {
        $id = Yii::$app->request->post('id');
        $product_list = ProductList::find()->where(['id' => $id])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = $product_list->sizeType->name;
        $residual = number_format($product_list->residual, 2, '.', '');
        return ['product_list' => $product_list, 'residual' => $residual, 'type' => $type];
    }


    /**
     * Finds the MakeProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MakeProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MakeProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
