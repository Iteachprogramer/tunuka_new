<?php

namespace common\models;

use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "expense_type".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Account[] $accounts
 * @property User $createdBy
 * @property User $updatedBy
 */
class ExpenseType extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE=0;

    public  static function getStatusList()
    {
            return [
                self::STATUS_ACTIVE => 'Faol',
                self::STATUS_INACTIVE => 'Faol emes',
            ];
     }



    public function getStatusTypesName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status, $this->status);
    }

    public static function getStatusBadges()
    {
        $labels = self::getStatusList();
        return
            [
                self::STATUS_INACTIVE => '<span class="badge badge-danger">' . ArrayHelper::getArrayValue($labels, self::STATUS_INACTIVE) . '</span>',
                self::STATUS_ACTIVE => '<span class="badge badge-success">' . ArrayHelper::getArrayValue($labels, self::STATUS_ACTIVE) . '</span>',
            ];
    }

    public function getStatusBadge()
    {
        return ArrayHelper::getArrayValue(self::getStatusBadges(), $this->status, $this->status);
    }
    public static function tableName()
    {
        return 'expense_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['expense_type_id' => 'id']);
    }

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

    public static function getMapExpense()
    {
        return ArrayHelper::map(ExpenseType::find()->andWhere(['status' => ExpenseType::STATUS_ACTIVE])->all(), 'id', 'name');
    }

    //</editor-fold>
}
