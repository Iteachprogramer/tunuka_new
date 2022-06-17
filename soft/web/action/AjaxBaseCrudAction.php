<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 21.06.2021, 13:57
 */

namespace soft\web\action;

use Yii;
use yii\helpers\Html;

class AjaxBaseCrudAction extends BaseCrudAction
{

    /**
     * @var string model title
     */
    public $title;

    public $returlUrl;

    public $closeButtonText;

    public $closeButtonOptions = ['class' => 'btn btn-default pull-right'];

    public function init()
    {
        parent::init();

    }

    /**
     * Renders close button
     * @return string
     */
    public function renderCloseButton()
    {
        if ($this->closeButtonText == null) {
            $this->closeButtonText = Yii::t('site', 'Close');
        }
        $options = $this->closeButtonOptions;
        $options['data-dismiss'] = 'modal';
        return Html::button($this->closeButtonText, $options);
    }


}