<?php

namespace common\models;

use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $fulla_name
 * @property string|null $phone
 * @property int|null $debt
 * @property int|null $client_type_id
 * @property string|null $leader
 * @property string|null $text
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Client extends \soft\db\ActiveRecord
{

    public $residue;
    private $_accountsSum;
    public $residue_dollar;
    private $outcomeSum;
    private $incomeSum;
    private $discountSum;
    private $accountsSumTotal;
    private $accountsSumDollar;

    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    const CLIENT_TYPE_PROVIDER = 1;
    const CLIENT_TYPE_CLIENT = 2;
    const CLIENT_TYPE_MOUTH = 3;

    /**
     * {@inheritdoc}
     */
    public static function clientTypes()
    {
        return [
            self::CLIENT_TYPE_CLIENT => 'Mijoz',
            self::CLIENT_TYPE_PROVIDER => 'Taminotchi',
            self::CLIENT_TYPE_MOUTH => 'Usta',
        ];
    }

    public function rules()
    {
        return [
            [['fulla_name', 'client_type_id'], 'required'],
            [['phone'], 'unique'],
            [['debt', 'client_type_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'debt_dollor'], 'integer'],
            [['text'], 'string'],
            ['last_updated', 'default', 'value' => time()],
            ['phone', 'match', 'pattern' => '/\+[9][9][8] [389][01345789] [0-9][0-9][0-9] [0-9][0-9] [0-9][0-9]/'],
            [['fulla_name', 'phone', 'leader'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        $this->phone = strtr($this->phone,
            [
                '+' => '',
                ' ' => '',
                '(' => '',
                ')' => '',
            ]
        );
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
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
            'fulla_name' => 'To\'liq ism familyasi',
            'phone' => 'Telefon no\'meri',
            'debt' => 'Qarzi',
            'client_type_id' => 'Klient turi',
            'leader' => 'Rahbari',
            'debt_dollor' => 'Qarzi yoki haqi dollarda',
            'residue' => 'Yakuni hisob kitob so\'mda',
            'residue_dollar' => 'Yakuni hisob kitob dollarda',
            'text' => 'Izoh',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public static function getProvider()
    {
        return ArrayHelper::map(Client::find()->where(['client_type_id' => self::CLIENT_TYPE_PROVIDER])->all(), 'id', 'fulla_name');
    }

    public static function getClient()
    {
        return ArrayHelper::map(Client::find()->where(['client_type_id' => self::CLIENT_TYPE_CLIENT])->orWhere(['client_type_id' => self::CLIENT_TYPE_MOUTH])->all(), 'id', 'fulla_name');
    }

    public static function getClientPhone()
    {
        return ArrayHelper::map(Client::find()->where(['client_type_id' => self::CLIENT_TYPE_CLIENT])->orWhere(['client_type_id' => self::CLIENT_TYPE_MOUTH])->all(), 'id', 'phone');
    }

    public static function getClientOne($id)
    {
        return ArrayHelper::map(Client::find()->where(['id' => $id])->all(), 'id', 'fulla_name');
    }

    public function getIncomes()
    {
        return $this->hasMany(Income::class, ['provider_id' => 'id']);
    }

    public function getOutcomeGroups()
    {
        return $this->hasMany(OutcomeGroup::class, ['client_id' => 'id']);
    }

    public function getAccounts()
    {
        return $this->hasMany(Account::class, ['client_id' => 'id']);
    }

    public function getIncomeAggregationSum()
    {
        return $this->getIncomes()
            ->select(['provider_id', 'counted' => 'SUM(total)'])
            ->groupBy('provider_id')
            ->asArray(true);
    }

    public function getIncomesSum()
    {
        if ($this->isNewRecord) {
            return null;
        }
        if ($this->incomeSum === null) {
            $sum = empty($this->incomeAggregationSum) ? 0 : $this->incomeAggregationSum[0]['counted'];
            $this->setIncomeSum($sum);
        }
        return $this->incomeSum;
    }

    public function setIncomeSum($income)
    {
        $this->incomeSum = floatval($income);
    }

    public function getOutcomeAggregationSum()
    {
        return $this->getOutcome()
            ->with('outcome')
            ->select(['client_id', 'counted' => 'SUM(total)'])
            ->groupBy('client_id')
            ->asArray(true);
    }

    public function getOutcomeSum()
    {
        if ($this->isNewRecord) {
            return null;
        }
        if ($this->outcomeSum === null) {
            $sum = empty($this->outcomeAggregationSum) ? 0 : $this->outcomeAggregationSum[0]['counted'];
            $this->setOutcomeSum($sum);
        }
        return $this->outcomeSum;
    }

    public function setOutcomeSum($outcomesum)
    {
        $this->outcomeSum = intval($outcomesum);
    }

    public function getDiscountAggregationSum()
    {
        return $this->getOutcomeGroups()
            ->select(['client_id', 'counted' => 'SUM(discount)'])
            ->groupBy('client_id')
            ->asArray(true);
    }

    public function getOutcomeGroupDiscount()
    {
        if ($this->isNewRecord) {
            return null;
        }
        if ($this->discountSum === null) {
            $sum = empty($this->discountAggregationSum) ? 0 : $this->discountAggregationSum[0]['counted'];
            $this->discountSum = intval($sum);
        }
        return $this->discountSum;
    }

    public function getOutcome()
    {
        return $this->hasMany(Outcome::class, ['client_id' => 'id']);
    }

    public function getIncomesCountWeight()
    {
        return $this->getIncomes()->andWhere(['unity_type_id' => 2])->sum('weight');
    }

    public function getIncomesCountWeightSum()
    {
        return $this->getIncomes()->andWhere(['unity_type_id' => 2])->sum('total');
    }

    public function getIncomesCountKg()
    {
        return $this->getIncomes()->andWhere(['unity_type_id' => 4])->sum('weight');
    }

    public function getIncomesCountKgSum()
    {
        return $this->getIncomes()->andWhere(['unity_type_id' => 4])->sum('total');
    }

    public function getIncomesCountNumer()
    {
        return $this->getIncomes()->andWhere(['unity_type_id' => 3])->sum('weight');
    }

    public function getIncomesCountNumerSum()
    {
        return $this->getIncomes()->andWhere(['unity_type_id' => 3])->sum('total');
    }

    /*
     *  Olingan yuklar
     */
    public function getOutcomeCountMetr()
    {
        return $this->getOutcome()->andWhere(['unit_id' => 2])->sum('total_size');
    }

    public function getOutcomeCountMetrSum()
    {
        return $this->getOutcome()->andWhere(['unit_id' => 2])->sum('total');
    }

    public function getOutcomeCountKg()
    {
        return $this->getOutcome()->andWhere(['unit_id' => 4])->sum('count');
    }

    public function getOutcomeCountKgSum()
    {
        return $this->getOutcome()->andWhere(['unit_id' => 4])->sum('total');
    }

    public function getOutcomeCountNumer()
    {
        return $this->getOutcome()->andWhere(['unit_id' => 3])->sum('count');
    }

    public function getOutcomeCountNumerSum()
    {
        return $this->getOutcome()->andWhere(['unit_id' => 3])->sum('total');
    }

    public function getIncomesAccountSum()
    {
        return abs(intval($this->getAccounts()->andWhere(['type_id' => Account::TYPE_INCOME, 'is_main' => null])->sum('sum')));
    }

    public function getOutComeAccountSum()
    {
        return abs(intval($this->getAccounts()->andWhere(['type_id' => Account::TYPE_OUTCOME])->sum('sum')));
    }

    public function getIncomesAccountSumDolar()
    {
        return abs(intval($this->getAccounts()->andWhere(['type_id' => Account::TYPE_INCOME, 'is_main' => null])->sum('dollar')));
    }

    public function getOutComeAccountSumDollar()
    {
        return abs(intval($this->getAccounts()->andWhere(['type_id' => Account::TYPE_OUTCOME])->sum('dollar')));
    }

    public function getAccountAggregationSum()
    {
        return $this->getAccounts()
            ->select(['client_id', 'counted' => 'SUM(sum)'])
            ->groupBy('client_id')
            ->asArray(true);
    }

    public function getAccountsSum()
    {
        if ($this->isNewRecord) {
            return null;
        }
        if ($this->accountsSumTotal === null) {
            $sum = empty($this->accountAggregationSum) ? 0 : $this->accountAggregationSum[0]['counted'];
            $this->accountsSumTotal = -1 * $sum;
        }
        return $this->accountsSumTotal;
    }

    public function getAccountAggregationDollar()
    {
        return $this->getAccounts()
            ->select(['client_id', 'counted' => 'SUM(dollar)'])
            ->groupBy('client_id')
            ->asArray(true);
    }

    public function getAccountsSumDollar()
    {
        if ($this->isNewRecord) {
            return null;
        }
        if ($this->accountsSumDollar === null) {
            $sum = empty($this->accountAggregationDollar) ? 0 : $this->accountAggregationDollar[0]['counted'];
            $this->accountsSumDollar = -1 * floatval($sum);
        }
        return $this->accountsSumDollar;
    }

    public function getFinishAccountSum()
    {
        return $this->getOutcomeSum() - $this->getOutcomeGroupDiscount() + $this->getAccountsSum() + $this->debt;
    }

    public function getFinishAccountSumDollar()
    {
        return $this->getIncomesSum() + $this->getAccountsSumDollar() + $this->debt_dollor;
    }

    public static function getMap()
    {
        return ArrayHelper::map(Client::find()->all(), 'id', 'fulla_name');
    }
}
