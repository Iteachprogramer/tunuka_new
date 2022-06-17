<?php

namespace common\models;

use soft\behaviors\TimestampConvertorBehavior;
use Yii;

/**
 * This is the model class for table "outcome".
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $product_type_id
 * @property float|null $size
 * @property float|null $count
 * @property float|null $total_size
 * @property float|null $total
 * @property int|null $unit_id
 * @property float|null $discount
 *
 * @property Client $client
 * @property ProductList $productType
 */
class Outcome extends \soft\db\ActiveRecord
{

  public $residual;
    //<editor-fold desc="Parent" defaultstate="collapsed">
    const SCENARIO_AKSESSUAR = "aksessuar";
    const SCENARIO_RULON = "rulon";
    const SCENARIO_PRODUCT = "product";

    const STATUS_NEW = 0;
    const STATUS_CONFIRMED = 1;

    public static function statusList()
    {
        return [
            self::STATUS_NEW => 'Jarayonda',
            self::STATUS_CONFIRMED => 'Jarayon tugatildi',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outcome';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_type_id', 'cost', 'client_id'], 'required'],
            [['client_id', 'product_type_id', 'unit_id', 'type_id', 'status', 'group_id'], 'integer'],
            [['size', 'count', 'total_size', 'total', 'discount', 'cost'], 'number'],
            [['count'], 'checkBeforeSold'],
            [['total_size'], 'checkBeforeSoldMetr'],
            ['discount', 'default', 'value' => 0],
            ['date', 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OutcomeGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductList::className(), 'targetAttribute' => ['product_type_id' => 'id']],
        ];
    }


    public function checkBeforeSold()
    {
        $product = $this->productType;
        if ($product) {
            $unity = $product->sizeType->name;
            $residual = $product->residual;
            if ($this->count > $residual) {
                $this->addError('count', "Skladda buncha yuk yo'q! Hozir skladda '$product->product_name' mahsulot $residual  $unity  mavjud!");
                return false;
            }
        }
    }

    public function checkBeforeSoldMetr()
    {
        $product = $this->productType;
        if ($product) {
            $unity = $product->sizeType->name;
            $residual = $product->residual;
            if ($this->total_size > $residual) {
                $this->addError('total_size', "Skladda buncha yuk yo'q! Hozir skladda '$product->product_name' mahsulot $residual  $unity mavjud!");
                return false;
            }
        }
    }

    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior', [
                'class' => TimestampConvertorBehavior::class,
                'attribute' => ['date'],
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->type_id = $this->productType->type_id;
            $this->unit_id = $this->productType->sizeType->id;
            if (!$this->total_size) {
                $this->total_size = $this->size * $this->count;
            }
            if ($this->unit_id != 2) {
                $this->total = intval($this->cost * $this->count);
            } else  {
                $this->total = intval($this->cost * $this->total_size);
            }
            return true;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => 'Mijoz',
            'product_type_id' => 'Mahsulot turi',
            'size' => 'O\'lchami',
            'count' => 'Miqdori',
            'total_size' => 'Umumiy o\'lchami',
            'total' => 'Umumiy summa',
            'unit_id' => 'Brlik',
            'date' => 'Sana',
            'cost' => 'Narx',
            'discount' => 'Chegirma',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(ProductList::className(), ['id' => 'product_type_id']);
    }

    public function getUnity()
    {
        return $this->hasOne(Units::className(), ['id' => 'unit_id']);
    }

    public function getGrpoup()
    {
        return $this->hasOne(OutcomeGroup::className(), ['id' => 'group_id']);
    }

    public function getProductTypeNotProduct()
    {
        return $this->hasOne(ProductList::className(), ['id' => 'product_type_id'])->andWhere(['!=', 'type_id', ProductList::TYPE_PRODUCT]);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public static function getItems($product_id, $group_id)
    {
        return self::find()
            ->andWhere(['product_type_id' => $product_id])
            ->andWhere(['group_id' => $group_id])
            ->all();
    }
}
