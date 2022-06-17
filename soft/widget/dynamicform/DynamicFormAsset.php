<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 24.07.2021, 10:06
 */

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 06.07.2021, 18:27
 */

namespace soft\widget\dynamicform;


class DynamicFormAsset extends \wbraganca\dynamicform\DynamicFormAsset
{

    public $js = ['yii2-dynamic-form.js'];

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        parent::init();
    }


}