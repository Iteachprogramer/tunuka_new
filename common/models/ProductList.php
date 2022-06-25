<?php

namespace common\models;

use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "product_list".
 *
 * @property int $id
 * @property int|null $type_id
 * @property float|null $residue
 * @property int|null $sort_order
 * @property int|null $size_type_id
 * @property float|null $selling_price_uz
 * @property float|null $selling_price_usd
 * @property float|null $selling_rentail
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $status
 *
 * @property User $createdBy
 * @property Units $sizeType
 * @property User $updatedBy
 */
class ProductList extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">
    private $_takenLoadsAmount;
    private $_soldLoadsAmount;
    private $_residual;
    public $price_type;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_list';
    }

    const  PRICE_TYPE_UZS = 1;
    const  PRICE_TYPE_USD = 2;


    /*
     *  Ombordagi mahulotni holatini aniqlab beradi active bolganda mijozlarga ko'rinadi
     */
    const STATUS_FACTORY = 0;
    const STATUS_SEND_ADMIN = 1;
    const STATUS_ACTIVE = 2;

    /*
     * Omborda Mahsulot yoki Tovar lgini aniqlab beradi
     */
    const TYPE_AKSESSUAR = 1;
    const TYPE_PRODUCT = 2;
    const TYPE_RULON = 3;

    /**
     * Sirtni shakli
     */

    const SURFACE_TYPE_SMOOTH = 0;
    const SURFACE_TYPE_MATOVIY = 1;

    public static function statuses()
    {
        return [
            self::STATUS_FACTORY => 'Ishlab chiqilmoqda',
            self::STATUS_SEND_ADMIN => 'Mahsulot qabul qilish kutilmoqda',
            self::STATUS_ACTIVE => 'Mahsulot omborga qabul qilindi'
        ];
    }

    public static function types()
    {
        return [
            self::TYPE_AKSESSUAR => 'Aksessuar',
            self::TYPE_PRODUCT => 'Mahsulot',
            self::TYPE_RULON => 'Rulon'
        ];
    }


    public function getTypesName()
    {
        return ArrayHelper::getValue(self::types(), $this->type_id, $this->type_id);
    }


    public static function surfaceTypes()
    {
        return [
            self::SURFACE_TYPE_SMOOTH => 'Silliq',
            self::SURFACE_TYPE_MATOVIY => 'Matoviy'
        ];
    }

    public function getsurfaceTypesName()
    {
        return ArrayHelper::getValue(self::surfaceTypes(), $this->surface_type, $this->surface_type);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return
            [
                [['product_name', 'type_id'], 'required'],
                [['type_id', 'sort_order', 'size_type_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status', 'price_type', 'surface_type', 'factory_expence'], 'integer'],
                [['residue', 'selling_price_uz', 'selling_price_usd', 'selling_rentail', 'selling_rentail_usd'], 'number'],
                [['residue', 'selling_price_uz', 'selling_price_usd', 'factory_expence'], 'checkNumber'],
                ['surface_type', 'default', 'value' => self::SURFACE_TYPE_SMOOTH],
                ['product_name', 'string', 'max' => 255,],
                ['product_name', 'unique', 'message' => 'Bu nomli mahsulot omborda mavjud'],
                [['sort_order', 'factory_expence', 'residue'], 'default', 'value' => 0],
                [['selling_price_uz', 'selling_rentail', 'selling_rentail_usd'], 'default', 'value' => 0],
                [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
                [['size_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['size_type_id' => 'id']],
                [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            ];
    }

    public function checkNumber()
    {

        if ($this->residue < 0) {
            $this->addError('residue', "Faqat musbat son kiritiladi");
            return false;
        } elseif ($this->selling_price_uz < 0) {
            $this->addError('selling_price_uz', "Faqat musbat son kiritiladi");
            return false;
        } elseif ($this->selling_price_usd < 0) {
            $this->addError('selling_price_usd', "Faqat musbat son kiritiladi");
            return false;
        } elseif ($this->factory_expence < 0) {
            $this->addError('factory_expence', "Faqat musbat son kiritiladi");
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_name' => 'Mahsulot nomi',
            'type_id' => 'Mahsulot turi',
            'residue' => 'Qoldig\'i',
            'price_type' => 'Narx turi',
            'residual' => 'Qoldiq (Metrda)',
            'size_type_id' => 'O\'lchov birligi',
            'selling_price_uz' => 'Narxi so\'mda',
            'selling_price_usd' => 'Narxi dollarda',
            'selling_rentail' => 'Chegirma narxi so\'mda',
            'selling_rentail_usd' => 'Chegirma narxi dollarda',
            'surface_type' => 'Shakli',
            'factory_expence' => 'Ishlab chiqarish uchun ketadiga harajat'
        ];
    }

    public function fields()
    {
        return [
            'id',
            'product_name',
            'type_id',
            'residue',
            'residual',
            'size_type_id' => function (ProductList $model) {
                return $model->sizeType->name;
            },
            'selling_price_uz',
            'selling_price_usd',
            'selling_rentail',
            'selling_rentail_usd',
            'surface_type',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'status',
            'price_type',
        ];
    }

//    public function beforeSave($insert)
//    {
//        $dollar = DollarCourse::find()->one();
//        if (parent::beforeSave($insert)) {
//            if ($this->price_type == ProductList::PRICE_TYPE_USD) {
//                $this->selling_price_uz = $this->selling_price_usd * $dollar->course;
//                $this->selling_rentail = $this->selling_rentail_usd * $dollar->course;
//            } else {
//                $this->selling_price_usd = round($this->selling_price_uz / $dollar->course,2);
//                $this->selling_rentail_usd = round($this->selling_rentail / $dollar->course,2);
//            }
//            return true;
//        }
//        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
//    }

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
    public function getSizeType()
    {
        return $this->hasOne(Units::className(), ['id' => 'size_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getIncome()
    {
        return $this->hasMany(Income::class, ['product_type_id' => 'id']);
    }

    public function getIncomeAksessuar()
    {
        return $this->getIncome()->joinWith('productType')
            ->andWhere(['=', 'product_list.type_id', ProductList::TYPE_AKSESSUAR])
            ->sum('weight');
    }

    public function getOutcome()
    {
        return $this->hasMany(Outcome::class, ['product_type_id' => 'id']);
    }

    public function getOutcomeAksessuarSum()
    {
        if ($this->isNewRecord) {
            return 0;
        }
        return $this->getOutcome()
            ->joinWith('productType')
            ->andWhere(['=', 'product_list.type_id', ProductList::TYPE_AKSESSUAR])
            ->sum('count');
    }

    public function getOutcomeRulonSum()
    {
        if ($this->isNewRecord) {
            return 0;
        }
        return $this->getOutcome()
            ->joinWith('productType')
            ->andWhere(['=', 'product_list.type_id', ProductList::TYPE_RULON])
            ->sum('total_size');
    }

    public function getOutcomeProductSum()
    {
        if ($this->isNewRecord) {
            return 0;
        }
        return $this->getOutcome()
            ->joinWith('productType')
            ->andWhere(['=', 'product_list.type_id', ProductList::TYPE_PRODUCT])
            ->sum('total_size');
    }

    public function getIncomeAggregation()
    {
        return $this->getIncome()
            ->joinWith('productType')
            ->select(['product_type_id', 'length' => 'SUM(length)'])
            ->andWhere(['!=', 'product_list.type_id', ProductList::TYPE_PRODUCT])
            ->groupBy('product_type_id')
            ->asArray(true);
    }

    /**
     * Jami sotilgan yukning miqdori (qopda)
     * @return int
     */
    public function getIncomeAmount()
    {
        if ($this->isNewRecord) {
            return 0;
        }
        if ($this->_takenLoadsAmount === null) {
            $metr = empty($this->incomeAggregation) ? 0 : $this->incomeAggregation[0]['length'];
            $this->setIncomeAmount($metr);
        }
        return $this->_takenLoadsAmount;
    }

    public function getWeightSum()
    {
        return floatval($this->getIncome()->joinWith('productType')->andWhere(['=', 'product_list.type_id', ProductList::TYPE_AKSESSUAR])->sum('weight'));
    }

    public function setIncomeAmount($takenLoadsAmount)
    {
        $this->_takenLoadsAmount = floatval($takenLoadsAmount);
    }

    public function getFactories()
    {
        return $this->hasMany(MakeProduct::class, ['product_id' => 'id']);
    }

    public function getFactoriesMakeProduct()
    {
        return MakeProduct::find()
            ->andWhere([
                'not in',
                'id',
                MakeProductItem::find()->select('make_id')
            ])->sum('size');
    }

    public function getFactoriesProduced()
    {
        return $this->hasMany(MakeProduct::class, ['produced_id' => 'id']);
    }

    public function getFactoriesSum()
    {
        return $this->getFactories()->sum('size');
    }

    public function getFactoriesProducedSum()
    {
        return $this->getFactoriesProduced()->joinWith('produced')->sum('factory_size');
    }

    public function getResidual()
    {
        if ($this->_residual === null) {
            if ($this->incomeAmount == 0 && $this->weightSum == 0) {
                $this->setResidual($this->residue - $this->outcomeProductSum - $this->outcomeAksessuarSum - $this->outcomeRulonSum + $this->factoriesProducedSum + $this->incomeAksessuar - $this->factoriesMakeProduct);
            } else {
                $this->setResidual($this->residue + $this->incomeAmount - $this->outcomeProductSum - $this->outcomeAksessuarSum + $this->factoriesProducedSum + $this->incomeAksessuar - $this->factoriesMakeProduct);

            }
        }
        return $this->_residual;
    }

    public function getResidualCost()
    {
        return $this->residual * $this->selling_price_uz;
    }

    public function setResidual($residual)
    {
        $this->_residual = floatval($residual);
    }

    //</editor-fold>
    public static function getMap()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'product_name');
    }

    public static function getAksessuar()
    {
        return ArrayHelper::map(self::find()->andWhere(['type_id' => ProductList::TYPE_AKSESSUAR])->all(), 'id', 'product_name');
    }

    public static function getRulon()
    {
        return ArrayHelper::map(self::find()->andWhere(['type_id' => ProductList::TYPE_RULON])->all(), 'id', 'product_name');
    }

    public static function getProduct()
    {
        return ArrayHelper::map(self::find()->andWhere(['type_id' => ProductList::TYPE_PRODUCT])->all(), 'id', 'product_name');
    }

    public static function getNotRulon()
    {
        return ArrayHelper::map(self::find()->andWhere(['!=', 'type_id', ProductList::TYPE_RULON])->all(), 'id', 'product_name');
    }

    public static function getResidualSum()
    {
        {
            $product_lists = self::find()->all();
            $result = 0;
            foreach ($product_lists as $product_list) {
                $result += $product_list->residualCost;
            }
            return $result;
        }
    }
}
