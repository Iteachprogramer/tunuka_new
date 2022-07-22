<?php

namespace common\models;

use soft\behaviors\TimestampConvertorBehavior;
use soft\helpers\ArrayHelper;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property int|null $client_id
 * @property int|null $type_id
 * @property int|null $sum
 * @property int|null $dollar
 * @property float|null $dollar_course
 * @property int|null $bank
 * @property int|null $total
 * @property string|null $comment
 * @property int|null $expense_type_id
 * @property int|null $is_main
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $date
 *
 * @property Client $client
 * @property User $createdBy
 * @property ExpenseType $expenseType
 * @property User $updatedBy
 */
class Account extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    /**
     * Klientlardan olingan pul
     */
    const TYPE_INCOME = 1;

    /**
     * Klientlarga berilgan pul
     */
    const TYPE_OUTCOME = 2;

    /**
     * Rasxod
     */
    const TYPE_EXPEND = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    public function getTypeName()
    {
        return ArrayHelper::getArrayValue(self::types(), $this->type_id);
    }

    public static function types()
    {
        return [
            self::TYPE_INCOME => 'Olindi',
            self::TYPE_OUTCOME => 'Berildi',
            self::TYPE_EXPEND => 'Rasxod',
        ];
    }

    public function getTypeBadge()
    {
        return Html::tag('span', $this->typeName, ['class' => 'badge badge-' . $this->bsClass]);
    }

    public function getBsClass()
    {
        switch ($this->type_id) {
            case self::TYPE_INCOME:
                return 'success';
            case self::TYPE_OUTCOME:
                return 'danger';
            case self::TYPE_EXPEND:
                return 'warning';
            default:
                return 'primary';
        }
    }

    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id',], 'required'],
            [['client_id', 'type_id', 'sum', 'bank', 'total', 'expense_type_id', 'is_main', 'created_at', 'updated_at', 'created_by', 'updated_by', 'employee_id', 'group_id', 'status'], 'integer'],
            [['dollar_course', 'dollar',], 'number'],
            [['comment'], 'string', 'max' => 255],
            ['date', 'safe'],
            ['date', 'default', 'value' => time()],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['expense_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExpenseType::className(), 'targetAttribute' => ['expense_type_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
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
                'attribute' => 'date',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => 'Klient',
            'type_id' => 'Pul',
            'sum' => 'So\'m',
            'dollar' => 'Dollar',
            'dollar_course' => 'Dollar kursi',
            'bank' => 'Bank',
            'total' => 'Umumiy summa', 'typeBadge' => 'Turi',
            'typeName' => 'Turi',
            'comment' => 'Izoh',
            'expense_type_id' => 'Rasxod turi',
            'employee_id' => 'Hodim',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'status' => 'Holati',
            'date' => 'Sana',
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

    public function getGroup()
    {
        return $this->hasOne(OutcomeGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseType()
    {
        return $this->hasOne(ExpenseType::className(), ['id' => 'expense_type_id']);
    }

    const SCENARIO_MAIN = 'main';

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (empty($this->sum) && empty($this->dollar) && empty($this->bank)) {
            $message = "Siz hech qanday summa kiritmadingiz! Ushbu maydonlardan kamida bittasini to'ldiring!";
            $this->addError('sum', $message);
            $this->addError('dollar', $message);
            $this->addError('bank', $message);
            return false;
        }
        $this->normalizeValues();
        return true;
    }

    public function normalizeValues()
    {
        if ($this->type_id == self::TYPE_INCOME) {
            $this->sum = abs(intval($this->sum));
            $this->dollar = abs(floatval($this->dollar));
            $this->bank = abs(intval($this->bank));
        } else {
            $this->sum = -1 * abs(intval($this->sum));
            $this->dollar = -1 * abs(floatval($this->dollar));
            $this->bank = -1 * abs(intval($this->bank));
        }
        $course = DollarCourse::find()->orderBy(['id' => SORT_DESC])->one();
        $this->dollar_course = abs($this->dollar_course);
        $this->total = $this->sum + $this->dollar * $this->dollar_course + $this->bank;
        if ($this->is_main) {
            $this->client_id = null;
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_MAIN] = ['sum', 'dollar', 'dollar_course', 'bank', 'comment', 'date'];
        return $scenarios;
    }

    public function getDollarTotal()
    {
        return $this->dollar * $this->dollar_course;
    }

    public function getisIncome()
    {
        return $this->type_id == self::TYPE_INCOME;
    }
}
