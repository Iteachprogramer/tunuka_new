<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 21.06.2021, 9:18
 */

namespace soft\web\action;

use Yii;
use yii\base\Model;

class CreateAction extends BaseCrudAction
{

    public $view = 'create';

    /**
     * @var string scenario of the model
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * Data to load for model. If not set Yii::$app->request->post() is used to load
     * @var array
     */
    public $data;

    /**
     * This attributes will be automatically filled after model load data
     * @var array model attributes with values
     */
    public $attributes = [];

    public $returnUrl = ['index'];

    public function run()
    {
        parent::run();
        $this->model->scenario = $this->scenario;
        if (!$this->data) {
            $this->data = Yii::$app->request->post();
        }
        if ($this->model->load($this->data)) {

            if (!empty($this->attributes)) {
                $this->model->setAttributes($this->attributes);
            }

            if ($this->model->save()) {
                return $this->controller->redirect($this->returnUrl);
            }
        }

        $this->viewParams['model'] = $this->model;
        return parent::renderView();
    }

}