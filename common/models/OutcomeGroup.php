<?php

namespace common\models;

use soft\behaviors\TimestampConvertorBehavior;
use Yii;

/**
 * This is the model class for table "outcome_group".
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $date
 * @property int|null $status
 * @property int|null $discount
 * @property int|null $total
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Outcome[] $outcomes
 * @property Client $client
 * @property User $createdBy
 * @property User $updatedBy
 */
class OutcomeGroup extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */


    public $phone_client_id;
    private $accountsSumTotal;
    private ?float $outcome_Sum=null;

    public static function tableName()
    {
        return 'outcome_group';
    }

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * {@inheritdoc}
     */


    public static function statusTypes()
    {
        return [
            self::STATUS_ACTIVE => "Jarayon tugatildi",
            self::STATUS_INACTIVE => "Jarayonda",
        ];
    }


    public function rules()
    {
        return [
            [['client_id', 'status', 'discount', 'total', 'created_by', 'updated_by', 'order_number', 'phone_client_id'], 'integer'],
            ['date', 'safe'],
            ['date', 'default', 'value' => time()],
            [['discount', 'total'], 'default', 'value' => 0],
            [['discount'], 'checkNumber'],
            [['where'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function checkNumber()
    {
        if ($this->discount < 0) {
            $this->addError('discount', "Faqat musbat son kiritiladi");
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\BlameableBehavior',
            [
                'class' => TimestampConvertorBehavior::class,
                'attribute' => ['date'],
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->total = $this->outcomeSum - $this->discount;
            $order_number = OrderNumber::find()->one();
            $nextDay = strtotime('+1 week', $order_number->date);
            if (Yii::$app->formatter->asDate($nextDay, 'dd.MM.yyyy') > Yii::$app->formatter->asDate(time(), 'dd.MM.yyyy')) {
                $next = $order_number->client_order_number + 1;
                $order_number->client_order_number = $next;
            } else {
                $order_number->client_order_number = 1;
                $order_number->date = time();
            }
            $order_number->save(false);
            $this->order_number = $order_number->client_order_number;
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
            'date' => 'Sana',
            'status' => 'Holati',
            'discount' => 'Chegirma',
            'total' => 'Umumiy summa',
            'where' => 'Manzil',
            'phone_client_id' => 'Telefon',
            'order_number' => 'Buyurtma raqami',
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutcomes()
    {
        return $this->hasMany(Outcome::className(), ['group_id' => 'id']);
    }


    public function getOutcomeAggregationSum()
    {
        return $this->getOutcomes()
            ->select(['group_id', 'counted' => 'SUM(total)'])
            ->groupBy('group_id')
            ->asArray(true);
    }

    public function getOutcomeSum()
    {
        if ($this->isNewRecord) {
            return null;
        }
        if ($this->outcome_Sum === null) {
            $sum = empty($this->outcomeAggregationSum) ? 0 : $this->outcomeAggregationSum[0]['counted'];
            $this->outcome_Sum = $sum;
        }
        return $this->outcome_Sum;
    }

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
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['group_id' => 'id']);
    }

    public function getAccountAggregationSum()
    {
        return $this->getAccounts()
            ->select(['group_id', 'counted' => 'SUM(total)'])
            ->groupBy('group_id')
            ->asArray(true);
    }

    public function getAccountSum()
    {
        if ($this->isNewRecord) {
            return null;
        }
        if ($this->accountsSumTotal === null) {
            $sum = empty($this->accountAggregationSum) ? 0 : $this->accountAggregationSum[0]['counted'];
            $this->accountsSumTotal = floatval($sum);
        }
        return $this->accountsSumTotal;
    }
    //</editor-fold>
}
