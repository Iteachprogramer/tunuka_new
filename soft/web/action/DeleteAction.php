<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 21.06.2021, 10:21
 */

namespace soft\web\action;

use Yii;
use yii\web\MethodNotAllowedHttpException;

class DeleteAction extends BaseCrudAction
{

    public $checkPostMethod = true;

    public $returnUrl = ['index'];

    public function run()
    {
        parent::run();
        $this->checkModel();
        if ($this->checkPostMethod){

            $method = Yii::$app->request->method;

            if ($method != 'POST'){
                throw new MethodNotAllowedHttpException('Method Not Allowed. This URL can only handle the POST request method');
            }

        }

        $this->model->delete();
        return $this->controller->redirect($this->returnUrl);

    }


}