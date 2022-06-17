<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

namespace soft\web;

use soft\db\ActiveRecord;
use Yii;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

/**
 *
 * @property-read bool $methodIsPost
 */
class CrudController  extends SoftController
{

    const ACTION_UPDATE = 'update';
    const ACTION_VIEW = 'view';
    const ACTION_DELETE = 'delete';

    public $disabledActions = [];

    /**
     * @var  ActiveRecord  Model Class name
     * This class must be instance of \soft\db\ActiveRecord
     */
    public $modelClass;

    /**
     * Displays a single Um model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->checkIfActionIsDisabled(self::ACTION_VIEW);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->checkIfActionIsDisabled(self::ACTION_UPDATE);

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Um model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->checkIfActionIsDisabled(self::ACTION_DELETE);

        $this->checkIfRequestMethodIsPost();

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds a single model for crud actions
     * You may override this method
     * @param $id
     * @return ActiveRecord
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        /** @var ActiveRecord $model */
        $model = $this->modelClass::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }

    /**
     * Checks if action is disabled
     * @param $action string action id
     * @throws NotFoundHttpException
     */
    public function checkIfActionIsDisabled($action)
    {
        if (in_array($action, $this->disabledActions)){
            not_found();
        }
    }

}