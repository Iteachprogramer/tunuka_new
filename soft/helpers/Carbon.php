<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 7/15/22, 9:28 AM
 */

namespace soft\helpers;

class Carbon extends \Carbon\Carbon
{

    /**
     * @return string[]
     */
    public static function weekDayNames(): array
    {
        return [
            1 => "Душанба",
            2 => "Сешанба",
            3 => 'Чоршанба',
            4 => 'Пайшанба',
            5 => 'Жума',
            6 => 'Шанба',
            0 => 'Якшанба'
        ];
    }

    /**
     * @return mixed
     */
    public function getUzbekDayOfWeek(int $length = 0)
    {
        $weekNumber = $this->dayOfWeek;
        $weekDayNames = self::weekDayNames();

        if(!isset($weekDayNames[$weekNumber])) {
            return $weekNumber;
        }

        $weekDayName = $weekDayNames[$weekNumber];
        return $length ? mb_substr($weekDayName, 0, $length) : $weekDayName;
    }
    
}