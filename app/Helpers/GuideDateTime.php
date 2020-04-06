<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;
use DateInterval;

class GuideDateTime {
    /**
     * Per task requirements, next day for broadcast schedule starts at 6 AM, not at midnight
     *
     * @return string
     * @throws \Exception
     */
    public static function getTodaysGuideDate()
    {
        $dateTimeNow = (new DateTime())->setTimezone(new DateTimeZone('Europe/Riga'));
        $dateTimeMorning = (new DateTime())->setTimezone(new DateTimeZone('Europe/Riga'))->setTime(6, 0);

        if ($dateTimeNow >= $dateTimeMorning) {
            $todaysDate = $dateTimeNow->format('Y-m-d');
        } else {
            $todaysDate = $dateTimeNow->sub(new DateInterval('P1D'))->format('Y-m-d');
        }

        return $todaysDate;
    }
}