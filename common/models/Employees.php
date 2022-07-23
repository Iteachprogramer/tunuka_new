<?php

namespace common\models;

use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $salary
 * @property int|null $is_factory
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Employees extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const IS_FACTORY_YES = 1;
    const IS_FACTORY_NO = 0;


    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Ishlayabdi',
            self::STATUS_INACTIVE => 'Ishlamayabdi',
        ];
    }

    public static function getIsFactoryList()
    {
        return [
            self::IS_FACTORY_YES => 'Ha',
            self::IS_FACTORY_NO => 'Yo\'q',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salary', 'is_factory', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['start_day', 'end_day'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'salary' => 'Oylik',
            'is_factory' => 'Ishlabchiqarish',
            'status' => 'Holati',
            'start_day' => 'Ish vaqti',
            'end_day' => 'Tugash vaqti',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getMakes()
    {
        return $this->hasMany(MakeProduct::className(), ['employee_id' => 'id']);
    }

    public function getMakesSum()
    {
        return intval($this->getMakes()->sum('total_expence'));
    }

    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['employee_id' => 'id']);
    }

    public function getAccountSum()
    {
        return intval($this->getAccounts()->andWhere(['status' => Account::STATUS_ACTIVE])->sum('sum'));
    }

    public static function getMap()
    {
        return ArrayHelper::map(self::find()->andWhere(['is_factory' => self::IS_FACTORY_YES])->andWhere(['status' => self::STATUS_ACTIVE])->all(), 'id', 'name');
    }

    public function getEmployeeFinishSum()
    {
        return $this->makesSum + $this->accountSum;
    }

    //</editor-fold>
}
