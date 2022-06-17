<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 21.06.2021, 9:03
 */

namespace soft\web\action;

class IndexAction extends BaseCrudAction
{

    /**
     * @var \yii\data\ActiveDataProvider
     */
    public $dataProvider;

    public $searchModel;

    public $view = 'index';

    public function run()
    {
        parent::run();
        $this->viewParams['dataProvider'] = $this->dataProvider;
        $this->viewParams['searchModel'] = $this->searchModel;
        return $this->controller->render($this->view, $this->viewParams);
    }

}