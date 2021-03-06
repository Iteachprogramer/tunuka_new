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
            [['client_id', 'product_type_id', 'unit_id', 'type_id', 'status', 'group_id'], 'integer',],
            [['size', 'count', 'total_size', 'total', 'discount', 'cost'], 'number',],
            [['size', 'count'], 'required', 'on' => self::SCENARIO_RULON],
            [['size', 'count', 'total_size', 'discount', 'cost'], 'checkNumber',],
            [['count', 'total_size', 'size'], 'checkBeforeSold'],
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
            $unity = $product->sizeType->id;
            $residual = $product->residual;
            if ($unity == 2) {
                if ($this->size > $residual) {
                    $residual = number_format($residual, 2);
                    $this->addError('size', "Skladda buncha yuk yo'q! Hozir skladda '$product->product_name' mahsulot $residual  $unity mavjud!");
                    return false;
                }
                if ($this->count && $this->size) {
                    $this->total_size = $this->count * $this->size;
                }
                if ($this->total_size > $residual) {
                    $residual = number_format($residual, 2);
                    $this->addError('total_size', "Skladda buncha yuk yo'q! Hozir skladda '$product->product_name' mahsulot $residual  $unity mavjud!");
                    return false;
                }
            } else {
                if ($this->count > $residual) {
                    $this->addError('count', "Skladda buncha yuk yo'q! Hozir skladda '$product->product_name' mahsulot $residual  $unity  mavjud!");
                    return false;
                }
            }

        }
    }

    public function checkNumber()
    {
        if ($this->count < 0) {
            $this->addError('count', "Faqat musbat son kiritiladi");
            return false;
        } elseif ($this->total_size < 0) {
            $this->addError('total_size', "Faqat musbat son kiritiladi");
            return false;
        } elseif ($this->size < 0) {
            $this->addError('size', "Faqat musbat son kiritiladi");
            return false;
        } elseif ($this->cost < 0) {
            $this->addError('cost', "Faqat musbat son kiritiladi");
            return false;
        } elseif ($this->discount < 0) {
            $this->addError('discount', "Faqat musbat son kiritiladi");
            return false;
        }
    }

    public function checkBeforeSoldMetr()
    {
        $product = $this->productType;
        if ($product) {
            $unity = $product->sizeType->name;
            $residual = $product->residual;
            if ($this->size > $residual) {
                $this->addError('size', "Skladda buncha yuk yo'q! Hozir skladda '$product->product_name' mahsulot $residual  $unity mavjud!");
                return false;
            }
            if ($this->count * $this->size > $residual) {
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
            if (empty($this->total_size) && empty($this->count) && empty($this->size)) {
                $message = "Siz hech qanday o'lchov birligini  kiritmadingiz! Ushbu maydonlardan kamida bittasini to'ldiring!";
                $this->addError('total_size', $message);
                $this->addError('count', $message);
                $this->addError('size', $message);
                return false;
            }
            $this->type_id = $this->productType->type_id;
            $this->unit_id = $this->productType->sizeType->id;
            if (!$this->total_size) {
                $this->total_size = $this->size * $this->count;
            }
            if ($this->unit_id != 2) {
                $this->total = intval($this->cost * $this->count);
            } else {
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

    public static function getChartRulons()
    {
        $today = strtotime('today');
        $lastMonth = strtotime('-1 week');
        return self::find()
            ->select(['outcome.product_type_id', 'sum(outcome.total_size) as total_size'])
            ->groupBy('outcome.product_type_id')
            ->orderBy('total_size DESC')
            ->andWhere(['outcome.type_id' => ProductList::TYPE_RULON])
            ->andWhere(['<=', 'outcome.date', $today])
            ->andWhere(['>=', 'outcome.date', $lastMonth])
            ->limit(8)
            ->with('productType')
            ->asArray()
            ->all();
    }

    public static function getChartProducts()
    {
        $today = strtotime('today');
        $lastMonth = strtotime('-1 week');
        return self::find()
            ->select(['outcome.product_type_id', 'sum(outcome.total_size) as total_size'])
            ->groupBy('outcome.product_type_id')
            ->orderBy('total_size DESC')
            ->andWhere(['outcome.type_id' => ProductList::TYPE_PRODUCT])
            ->andWhere(['<=', 'outcome.date', $today])
            ->andWhere(['>=', 'outcome.date', $lastMonth])
            ->limit(8)
            ->with('productType')
            ->asArray()
            ->all();
    }

    public static function getChartAksessuar()
    {
        $today = strtotime('today');
        $lastMonth = strtotime('-1 week');
        return self::find()
            ->select(['outcome.product_type_id', 'sum(outcome.count) as count'])
            ->groupBy('outcome.product_type_id')
            ->orderBy('count DESC')
            ->andWhere(['outcome.type_id' => ProductList::TYPE_AKSESSUAR])
            ->andWhere(['<=', 'outcome.date', $today])
            ->andWhere(['>=', 'outcome.date', $lastMonth])
            ->limit(8)
            ->with('productType')
            ->asArray()
            ->all();
    }
    public static function getChartClients()
    {
        $today = strtotime('today');
        $lastMonth = strtotime('-1 week');
        return self::find()
            ->select(['outcome.client_id', 'sum(outcome.total) as total'])
            ->groupBy('outcome.client_id')
            ->orderBy('total DESC')
            ->andWhere(['<=', 'outcome.date', $today])
            ->andWhere(['>=', 'outcome.date', $lastMonth])
            ->limit(8)
            ->with('client')
            ->asArray()
            ->all();
    }
    public static function getRangeClient($begin, $end)
    {
        return self::find()
            ->select(['outcome.client_id', 'sum(outcome.total) as total'])
            ->groupBy('outcome.client_id')
            ->orderBy('total DESC')
            ->andWhere(['<=', 'outcome.date', $end])
            ->andWhere(['>=', 'outcome.date', $begin])
            ->limit(8)
            ->with('client')
            ->asArray()
            ->all();

    }
    public static function getRangeRulon($begin, $end)
    {
        return self::find()
            ->select(['outcome.product_type_id', 'sum(outcome.total_size) as total_size'])
            ->groupBy('outcome.product_type_id')
            ->orderBy('total_size DESC')
            ->andWhere(['outcome.type_id' => ProductList::TYPE_RULON])
            ->andWhere(['<=', 'outcome.date', $end])
            ->andWhere(['>=', 'outcome.date', $begin])
            ->limit(8)
            ->with('productType')
            ->asArray()
            ->all();

    }
    public static function getRangeProduct($begin, $end)
    {
        return self::find()
            ->select(['outcome.product_type_id', 'sum(outcome.total_size) as total_size'])
            ->groupBy('outcome.product_type_id')
            ->orderBy('total_size DESC')
            ->andWhere(['outcome.type_id' => ProductList::TYPE_PRODUCT])
            ->andWhere(['<=', 'outcome.date', $end])
            ->andWhere(['>=', 'outcome.date', $begin])
            ->limit(8)
            ->with('productType')
            ->asArray()
            ->all();

    }
    public static function getRangeAksessuar($begin, $end)
    {
        return self::find()
            ->select(['outcome.product_type_id', 'sum(outcome.count) as count'])
            ->groupBy('outcome.product_type_id')
            ->orderBy('count DESC')
            ->andWhere(['outcome.type_id' => ProductList::TYPE_AKSESSUAR])
            ->andWhere(['<=', 'outcome.date', $end])
            ->andWhere(['>=', 'outcome.date', $begin])
            ->limit(8)
            ->with('productType')
            ->asArray()
            ->all();

    }

    public static function getSumOutcome($type_id,$group_id){
        return self::find()
            ->andWhere(['type_id' => $type_id])
            ->andWhere(['group_id' => $group_id])
            ->sum('total');
    }
    public static function getSumOutcomeTotalSize($type_id,$group_id){
        return number_format(self::find()
            ->andWhere(['type_id' => $type_id])
            ->andWhere(['group_id' => $group_id])
            ->sum('total_size'),2);
    }
}
