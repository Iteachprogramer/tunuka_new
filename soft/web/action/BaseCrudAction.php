<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 21.06.2021, 8:59
 */

namespace soft\web\action;

use yii\web\NotFoundHttpException;

class BaseCrudAction extends \yii\base\Action
{

    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;

    /**
     * @var string view name must be rendered
     */
    public $view;

    /**
     * @var array params for view
     */
    public $viewParams = [];

    /**
     * @var callable
     */
    public $checkAccess;

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this);
        }
        return true;
    }

    public function renderView()
    {
        return $this->controller->render($this->view, $this->viewParams);
    }

    public function checkModel()
    {
        if ($this->model == null){
            throw new NotFoundHttpException('Page not found!');
        }
    }

}