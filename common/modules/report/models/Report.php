<?php

namespace common\modules\report\models;

use common\models\Employees;
use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $date
 * @property float|null $work_time
 * @property string|null $start_day
 * @property string|null $end_day
 *
 * @property Employees $employee
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', ], 'required'],
            [['date', 'employee_id'], 'integer'],
            [['start_day', 'end_day'], 'safe'],
            [['date'],'default','value'=>strtotime(date('Y-m-d'))],
            [['work_time'], 'number'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['work_time'], 'number'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Hodimlar royhati',
            'date' => 'Sana',
            'work_time' => 'Work Time',
            'start_day' => 'Ish boshlangan vaqt',
            'end_day' => 'Ish yakunlangan vaqt',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee_id']);
    }
}
