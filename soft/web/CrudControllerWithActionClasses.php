<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

namespace soft\web;

use soft\db\ActiveRecord;
use soft\web\action\DeleteAction;
use soft\web\action\IndexAction;
use soft\web\action\UpdateAction;
use soft\web\action\ViewAction;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 *
 * @property-read mixed $model
 */
class CrudControllerWithActionClasses extends SoftController
{

    const ACTION_INDEX = 'index';
    const ACTION_UPDATE = 'update';
    const ACTION_VIEW = 'view';
    const ACTION_DELETE = 'delete';

    /**
     * @var  ActiveRecord  Model Class name
     * This class must be instance of \soft\db\ActiveRecord
     */
    public $modelClass;

    public $disabledActions = [];
    public $dataProvider;
    public $searchModel;

    private $_model;

    public function init()
    {
        if ($this->modelClass == null) {
            throw new InvalidConfigException('`modelClass` property must be set!');
        }
        parent::init();
    }

    public function actions()
    {
        $actions = [];
        $disabledActions = $this->disabledActions;
        $model = $this->getModel();

        if (!in_array(self::ACTION_INDEX, $disabledActions)) {

            $this->prepareDataProvider();

            $actions['index'] = ArrayHelper::merge([
                'class' => IndexAction::class,
                'dataProvider' => $this->dataProvider,
                'searchModel' => $this->searchModel,
            ], $this->indexActionOptions());
        }
        if (!in_array(self::ACTION_VIEW, $disabledActions)) {
            $actions['view'] = ArrayHelper::merge([
                'class' => ViewAction::class,
                'model' => $model,
            ], $this->viewActionOptions());
        }

        if (!in_array(self::ACTION_UPDATE, $disabledActions)) {
            $actions['update'] = ArrayHelper::merge([
                'class' => UpdateAction::class,
                'model' => $model,
            ], $this->updateActionOptions());
        }

        if (!in_array(self::ACTION_DELETE, $disabledActions)) {
            $actions['delete'] = ArrayHelper::merge([
                'class' => DeleteAction::class,
                'model' => $model,
            ], $this->deleteActionOptions());
        }
        return $actions;
    }

    /**
     * @return array Options for index action
     * @see IndexAction
     */
    public function indexActionOptions()
    {
        return [];
    }

    /**
     * @return array Options for view action
     * @see ViewAction
     */
    public function viewActionOptions()
    {
        return [];
    }

    /**
     * @return array Options for update action
     * @see UpdateAction
     */
    public function updateActionOptions()
    {
        return [];
    }

    /**
     * @return array Options for delete action
     * @see DeleteAction
     */
    public function deleteActionOptions()
    {
        return [];
    }


    public function prepareDataProvider()
    {
        if ($this->dataProvider == null) {
            $this->dataProvider = new ActiveDataProvider([
                'query' => $this->modelClass::find(),
            ]);
        }

    }

    public function getModel()
    {
        if ($this->_model == null) {
            $modelClass = $this->modelClass;
            $model = $modelClass::find()->andWhere([$modelClass::tableName() . '.id' => Yii::$app->request->get('id')])->one();
            $this->model = $model;
        }
        return $this->_model;

    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

}