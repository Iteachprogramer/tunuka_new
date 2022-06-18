<?php

namespace common\models;

use soft\behaviors\TimestampConvertorBehavior;
use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "income".
 *
 * @property int $id
 * @property int|null $product_type_id
 * @property float|null $cost 1 tonna uchun narx
 * @property int|null $provider_id Ta\minotchi
 * @property float|null $weight qancha umumiy tonna mahsulot kelgani yoziladi
 * @property float|null $length umumiy necha metr ekanligi
 * @property float|null $cost_of_living umumiy necha metr ekanligi
 * @property float|null $dollar_course Sotib olayotgan vaqtdagi  kurs narxi
 * @property float|null $total Umumiy summa
 * @property float|null $price_per_meter 1 metr uchun narx
 * @property int|null $unity_type_id Birlik turi
 * @property int|null $created_at Yaratilgan vaqt
 * @property int|null $updated_at O'zgartirilgan vaqt
 * @property int|null $created_by Yaratgan
 * @property int|null $updated_by O'zgartirgan
 * @property int|null $date Yuk olingan sana
 *
 * @property User $createdBy
 * @property ProductList $productType
 * @property Client $provider
 * @property Units $unityType
 * @property User $updatedBy
 */
class Income extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">
    /**
     * {@inheritdoc}
     */
    const COST_TYPE_SUM = 1;
    const COST_TYPE_USD = 2;


    public static function typesUsd()
    {
        return [
            self::COST_TYPE_SUM => 'So\'m',
            self::COST_TYPE_USD => 'Dollar',
        ];
    }

    public function getTypesName()
    {
        return ArrayHelper::getValue(self::typesUsd(), $this->cost_type, $this->cost_type);
    }

    public static function tableName()
    {
        return 'income';
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $dollar_course = DollarCourse::find()->one();
                $this->cost_type = self::COST_TYPE_USD;
                $this->total = -1 * intval($this->cost * $this->weight);
                $this->unity_type_id = $this->productType->sizeType->id;
            }
            return true;
        }
        return parent::beforeSave($insert);
    }

    public function rules()
    {
        return [
            [['product_type_id', 'provider_id', 'cost', 'weight'], 'required'],
            [['product_type_id', 'provider_id', 'unity_type_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'cost_type'], 'integer'],
            ['date', 'safe'],
            ['length', 'default', 'value' => 0],
            ['weight', 'default', 'value' => 0],
            [['cost', 'weight', 'length', 'cost_of_living', 'dollar_course', 'total', 'price_per_meter'], 'number'],
            [['cost', 'weight', 'length', 'cost_of_living',], 'checkNumber'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductList::className(), 'targetAttribute' => ['product_type_id' => 'id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['provider_id' => 'id']],
            [['unity_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['unity_type_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }
    public function checkNumber()
    {
        if ($this->cost < 0) {
            $this->addError('cost', "Faqat musbat son kiritiladi");
            return false;
        }
        elseif ($this->length < 0) {
            $this->addError('length', "Faqat musbat son kiritiladi");
            return false;
        }
        elseif ($this->weight < 0) {
            $this->addError('weight', "Faqat musbat son kiritiladi");
            return false;
        }
        elseif ($this->cost_of_living < 0) {
            $this->addError('cost_of_living', "Faqat musbat son kiritiladi");
            return false;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            [
                'class' => TimestampConvertorBehavior::class,
                'attribute' => ['date'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_type_id' => 'Mahsulot turi',
            'cost' => 'Narxi',
            'provider_id' => 'Ta\'minotchi',
            'weight' => 'Og\'irligi',
            'length' => 'umumiy necha metr',
            'cost_of_living' => 'Harajat dollarda',
            'dollar_course' => 'Olingan vaqtdagi dollar kursi',
            'total' => 'Summa dollarda',
            'price_per_meter' => 'Bir metr narxi dollarda',
            'unity_type_id' => 'Birlik',
            'cost_type' => 'Narx turi',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'date' => 'Sana',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductList::className(), ['id' => 'product_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvider()
    {
        return $this->hasOne(Client::className(), ['id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnityType()
    {
        return $this->hasOne(Units::className(), ['id' => 'unity_type_id']);
    }
    public function getOutcomeItems()
    {
        return $this->hasMany(OutcomeItem::className(), ['income_id' => 'id']);
    }
    public function getFactories()
    {
        return $this->hasMany(MakeProductItem::className(), ['income_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
//    public function afterSave($insert, $changedAttributes)
//    {
//        if ($insert) {
//            if ($this->provider) {
//                $this->provider->updateLastAction();
//            }
//        }
//    }
}
