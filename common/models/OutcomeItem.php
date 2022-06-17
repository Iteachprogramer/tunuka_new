<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outcome_item".
 *
 * @property int $id
 * @property int $income_id
 * @property int $outcome_id
 * @property float|null $outcome_size
 * @property float|null $residue_size
 *
 * @property Income $income
 * @property Outcome $outcome
 */
class OutcomeItem extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'outcome_item';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['income_id', 'outcome_id'], 'required'],
            [['income_id', 'outcome_id'], 'integer'],
            [['outcome_size', 'residue_size'], 'number'],
            [['income_id'], 'exist', 'skipOnError' => true, 'targetClass' => Income::className(), 'targetAttribute' => ['income_id' => 'id']],
            [['outcome_id'], 'exist', 'skipOnError' => true, 'targetClass' => Outcome::className(), 'targetAttribute' => ['outcome_id' => 'id']],
        ];
    }




    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'income_id' => Yii::t('app', 'Income ID'),
            'outcome_id' => Yii::t('app', 'Outcome ID'),
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
    public function getOutcome()
    {
        return $this->hasOne(Outcome::className(), ['id' => 'outcome_id']);
    }
    
    //</editor-fold>
}
