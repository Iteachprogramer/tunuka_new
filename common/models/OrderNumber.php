<?php

namespace common\models;

use soft\behaviors\TimestampConvertorBehavior;
use Yii;

/**
 * This is the model class for table "order_number".
 *
 * @property int $id
 * @property int|null $client_order_number
 * @property int|null $finish_order_number
 * @property int|null $date
 */
class OrderNumber extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_number';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampConvertorBehavior::class,
                'attribute' => ['date'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_order_number', 'finish_order_number',], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_order_number' => Yii::t('app', 'Client Order Number'),
            'finish_order_number' => Yii::t('app', 'Finish Order Number'),
            'date' => Yii::t('app', 'Date'),
        ];
    }
    //</editor-fold>

}
