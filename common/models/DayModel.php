<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 20.10.2021, 16:33
 */

namespace common\models;


use common\models\traits\DayModelFilterTrait;
use common\modules\report\models\Report;
use soft\helpers\ArrayHelper;
use soft\helpers\Url;
use yii\base\Model;
use soft\helpers\Carbon;
use yii\helpers\Html;

/**
 *
 * @property-read array $prevMonth
 * @property-read false|int $firstDay
 * @property-read array $nextMonth
 * @property-read int $daysCount
 * @property-read mixed $monthName
 * @property-read false|int $nextMonthFirstDay
 * @property-read \soft\helpers\Carbon[] $dates
 * @property-read array $days
 */
class DayModel extends Model
{



    const MIN_YEAR = 2020;

    public $month;
    public $year;
    public $title;
    private $_values;

    /**
     * @var null|array
     */
    private $_days;

    /**
     * @var Carbon[]
     */
    private $_dates;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'month'], 'required'],
            [['year', 'month'], 'integer'],
            ['year', 'in', 'range' => array_keys(self::years())],
            ['month', 'in', 'range' => array_keys(self::months())],
        ];
    }

    /**
     * @return array yillar ro'yxati
     */
    public static function years()
    {
        $years = [];
        $nextYear = (int)(date('Y')) + 1;
        $i = self::MIN_YEAR;
        while ($i <= $nextYear) {
            $years[$i] = $i;
            $i++;
        }
        return $years;
    }

    /**
     * @return array yillar ro'yxati
     */
    public static function months()
    {
        return [
            1 => "Январ",
            2 => "Феврал",
            3 => 'Март',
            4 => 'Aпрел',
            5 => 'Май',
            6 => 'Июн',
            7 => 'Июл',
            8 => 'Aвгуст',
            9 => 'Сентябр',
            10 => 'Октябр',
            11 => 'Ноябр',
            12 => 'Декабр'
        ];
    }

    /**
     * @return string[]
     */
    public static function weeks()
    {
        return [
            1 => "Душ",
            2 => "Сеш",
            3 => 'Чорш',
            4 => 'Пайш',
            5 => 'Жум',
            6 => 'Шан',
            0 => 'Якш'
        ];
    }

    /**
     * Normalize values
     */
    public function normalizeValues()
    {
        $this->validate();

        if ($this->hasErrors('year')) {
            $this->year = (int)date('Y');
        }

        if ($this->hasErrors('month')) {
            $this->month = (int)date('m');
        }
    }

    /**
     * @return array
     */
    public function getDays(): array
    {
        if ($this->_days === null) {

            $year = $this->year;
            $month = (int)$this->month;
            $weekdays = self::weeks();

            if ($month < 10) {
                $month = '0' . $month;
            }

            $days = [];

            for ($day = 1; $day <= 31; $day++) {

                if (checkdate($month, $day, $year)) {

                   

                    $date = $day . '.' . $month . '.' . $year;
                    $timestamp = strtotime($date);
                    $weekDayNumber = date('w', $timestamp);

                    $days[$day] = [
                        'timestamp' => $timestamp,
                        'date' => $date,
                        'weekDayNumber' => $weekDayNumber,
                        'weekDayName' => ArrayHelper::getArrayValue($weekdays, $weekDayNumber),
                        'isSunday' => $weekDayNumber == 0,
                        'dayNumber' => $day,
                    ];
                }
            }

            $this->_days = $days;
        }

        return $this->_days;
    }

    /**
     * @return int
     */
    public function getDaysCount(): int
    {
        return count($this->days);
    }

    /**
     * @return false|int oyning birinchi kuni (timestamp formatida)
     */
    public function getFirstDay()
    {
        return strtotime("01." . $this->month . "." . $this->year);
    }

    /**
     * @return false|int keyingi oyning birinchi kuni (timestamp formatida)
     */
    public function getNextMonthFirstDay()
    {
        return strtotime('+1 month', $this->getFirstDay());
    }

    /**
     * @return array
     */
    public function getNextMonth()
    {
        if ($this->month == 12) {
            return [
                'month' => 1,
                'year' => $this->year + 1,
            ];
        }
        return [
            'month' => $this->month + 1,
            'year' => $this->year
        ];
    }

    /**
     * @return array
     */
    public function getPrevMonth()
    {
        if ($this->month == 1) {
            return [
                'month' => 12,
                'year' => $this->year - 1,
            ];
        }
        return [
            'month' => $this->month - 1,
            'year' => $this->year
        ];
    }

    /**
     * @return mixed
     */
    public function getMonthName()
    {
        return ArrayHelper::getArrayValue(self::months(), $this->month, $this->month);
    }

    /**
     * @return Carbon[]
     */
    public function getDates(): array
    {
        if ($this->_dates === null) {

            $year = $this->year;

            $month = (int)$this->month;
            if ($month < 10) {
                $month = '0' . $month;
            }

            $dates = [];
            for ($day = 1; $day <= 31; $day++) {
                if (checkdate($month, $day, $year)) {
                    if ($day < 10) {
                        $day = '0' . $day;
                    }
                    $date = $day . '.' . $month . '.' . $year;

                    $dates[$day] = new Carbon($date);
                }
            }

            $this->_dates = $dates;
        }

        return $this->_dates;
    }
    public function getValues(): array
    {
        if ($this->_values === null) {
            $values = Report::find()
                ->andWhere(['>=', 'date', $this->firstDay])
                ->andWhere(['<', 'date', $this->nextMonthFirstDay])
                ->asArray()
                ->select(['id', 'date', 'end_day', 'start_day','employee_id'])
                ->indexBy(function ($row) {
                    return $row['date'] . '_' . $row['employee_id'];
                })
                ->all();

            $this->_values = $values;
        }
        return $this->_values;
    }
    /**
     * @param $options array
     * @param $url mixed
     * @param $text string
     * @return string
     */
    public function renderNextMonthLink($options = [], $url = null, $text = null)
    {

        if ($url == null) {
            $next = $this->getNextMonth();
            $url = Url::current(['year' => $next['year'], 'month' => $next['month']]);
        }

        $options = ArrayHelper::merge($options, ['class' => 'btn bg-primary btn-flat']);

        if ($text == null) {
            $text = '<i class="fa fa-chevron-right"></i>';
        }

        return Html::a($text, $url, $options);

    }

    /**
     * @param $options array
     * @param $url mixed
     * @param $text string
     * @return string
     */
    public function renderPrevMonthLink($options = [], $url = null, $text = null)
    {

        if ($url == null) {
            $prev = $this->getPrevMonth();
            $url = Url::current(['year' => $prev['year'], 'month' => $prev['month']]);
        }
        $options = ArrayHelper::merge($options, ['class' => 'btn bg-primary btn-flat mr-1']);
        if ($text == null) {
            $text = '<i class="fa fa-chevron-left"></i>';
        }
        return Html::a($text, $url, $options);

    }
}
