<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 21.06.2021, 10:17
 */

namespace soft\web\action;


use yii\web\NotFoundHttpException;

class ViewAction extends BaseCrudAction
{

    public $view = 'view';

    public function run()
    {
        parent::run();
        if ($this->model == null) {
            throw new NotFoundHttpException('Page not found!');
        }
        $this->viewParams['model'] = $this->model;
        return parent::renderView();
    }


}