<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "make_product_item".
 *
 * @property int $id
 * @property int $income_id
 * @property int $make_id
 * @property float|null $outcome_size
 * @property float|null $residue_size
 *
 * @property Income $income
 * @property MakeProduct $make
 */
class MakeProductItem extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'make_product_item';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['income_id', 'make_id'], 'required'],
            [['income_id', 'make_id'], 'integer'],
            [['outcome_size', 'residue_size'], 'number'],
            [['income_id'], 'exist', 'skipOnError' => true, 'targetClass' => Income::className(), 'targetAttribute' => ['income_id' => 'id']],
            [['make_id'], 'exist', 'skipOnError' => true, 'targetClass' => MakeProduct::className(), 'targetAttribute' => ['make_id' => 'id']],
        ];
    }

    /**
    * {@inheritdoc}
    */
//    public function behaviors()
//    {
//        return [
//            'yii\behaviors\TimestampBehavior',
//            'yii\behaviors\BlameableBehavior',
//        ];
//    }

    /**
    * {@inheritdoc}
    */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'income_id' => Yii::t('app', 'Income ID'),
            'make_id' => Yii::t('app', 'Make ID'),
            'outcome_size' => Yii::t('app', 'Outcome Size'),
            'residue_size' => Yii::t('app', 'Residue Size'),
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getIncome()
    {
        return $this->hasOne(Income::className(), ['id' => 'income_id']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMake()
    {
        return $this->hasOne(MakeProduct::className(), ['id' => 'make_id']);
    }
    
    //</editor-fold>
}
