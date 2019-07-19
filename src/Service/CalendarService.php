<?php

namespace App\Service;


use Exception;

/**
 * Class CalendarService
 * @package App\Service
 */
final class CalendarService
{
    /**
     * @var int
     */
    private $beginningYear = 1990;

    /**
     * @var int
     */
    private $evenMonthDays = 21;

    /**
     * @var int
     */
    private $oddMonthDays = 22;

    /**
     * @var int
     */
    private $leapByYear = 5;

    /**
     * @var int
     */
    private $leapMonth = 13;

    /**
     * @var int
     */
    private $daysNum = 7;

    /**
     * @var int
     */
    private $monthsNum = 13;

    /**
     * @var array
     */
    const WEEK_DAYS = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];

    /**
     * CalendarService constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $date
     * @return string
     * @throws Exception
     */
    public function getDayByDate(string $date): string
    {
        [$day, $month, $year] = explode('.', $date);

        $year = (int)$year;
        $month = (int)$month;
        $day = (int)$day;

        // validation input
        $this->validation($date);

        // Compute day offset in year
        $offset = $this->getDayOffsetInYear($this->oddMonthDays);

        // Monday
        $outDay = 1;
        for ($i = 0; $i < ($year - $this->beginningYear); $i++) {
            // if is leap year subtract next day
            if ((($i % $this->leapByYear) === 0) || $i == 0) {
                $outDay -= ($offset + 1);
            } else {
                $outDay -= $offset;
            }

            if ($outDay === 0) {
                $outDay = $this->daysNum;
            } elseif ($outDay < 0) {
                $outDay = $this->daysNum + $outDay;
            }
        }

        /**
         * Compute offset days
         */
        $outDay += $this->getDayOffsetInMonth($month);
        $outDay = $outDay % $this->daysNum;

        /**
         * Days
         */
        for ($i = 1; $i <= $day; $i++) {
            if ($i !== 1) {
                $outDay ++;
            }

            if ($outDay > $this->daysNum) {
                $outDay = 1;
            }
        }

        if ($outDay === 0) {
            $outDay = $this->daysNum;
        } elseif ($outDay < 0) {
            $outDay = $this->daysNum + $outDay;
        }

        return self::WEEK_DAYS[$outDay];
    }

    /**
     * @param $monthDays
     * @param bool $odd
     * @return int
     */
    private function getDayOffsetInYear($monthDays, $odd = true): int
    {
        // even months
        $months = (int)($this->monthsNum / 2);
        if($odd){
            // odd months
            $months = ($this->monthsNum % 2 !== 0) ? $this->monthsNum - $months : $months;
        }

        if ($monthDays % $this->daysNum !== 0) {
            //Compute rest of the division ( month by week)
            $offsetDays = $monthDays % $this->daysNum;

            // Compute additional repeated days in month.
            $i = $months * $offsetDays;

            // Compute rest of days
            if($i <= $this->daysNum){
                return $this->daysNum - $i;
            }else{
                return $this->daysNum - ($i % $this->daysNum);
            }
        }

        return 0;
    }

    /**
     * @param $month
     * @param $year
     * @return int
     */
    private function getDayOffsetInMonth($month): int
    {
        // Don't calculate first month
        $month--;

        if ($month === 0) {
            return 0;
        }

        $allDays = 0;
        for ($i = 1; $i <= $month; $i++) {
            if (($i % 2) === 0) {
                // compute all days
                $allDays += $this->evenMonthDays;
            } else {
                $allDays += $this->oddMonthDays;
            }
        }

        $outDay = $allDays % $this->daysNum;

        if ($outDay === 0) {
            $outDay = $this->daysNum;
        } elseif ($outDay < 0) {
            $outDay = (($this->daysNum + $outDay) > $this->daysNum) ? ($this->daysNum % $outDay) : ($this->daysNum + $outDay);
        }

        return $outDay;
    }

    /**
     * @param string $date
     * @throws Exception
     */
    private function validation(string $date): void
    {
        $dateArr = explode('.', $date);
        if (count($dateArr) !== 3) {
            throw new Exception('Date is incorrect '.$date);
        }

        [$day, $month, $year] = $dateArr;
        $month = (int)$month;
        $day = (int)$day;
        $year = (int)$year;

        if ($year < $this->beginningYear) {
            throw new Exception('Year has to be bigger or equal than '.$this->beginningYear);
        } elseif ($month > $this->monthsNum || $month < 0) {
            throw new Exception('Month has to be between 1 than '.$this->monthsNum);
        } elseif (($day > $this->oddMonthDays-1 || $day < 0) && $month == $this->leapMonth) {
            throw new Exception('Day has to be between 1 than '.($this->oddMonthDays-1).' in leap year.');
        } elseif (($day > $this->evenMonthDays || $day < 0) && ($month % 2) !== 0) {
            throw new Exception('Day has to be between 1 than '.$this->evenMonthDays.' in regular month.');
        } elseif (($day > $this->oddMonthDays || $day < 0) && ($month % 2) === 0) {
            throw new Exception('Day has to be between 1 than '.$this->oddMonthDays.' in odd month.');
        }
    }
}
