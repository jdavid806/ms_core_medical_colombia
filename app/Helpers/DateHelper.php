<?php

namespace App\Helpers;

use App\Enum\FrequencyEnum;
use Carbon\Carbon;

class DateHelper
{
    public static function addFrequencyToDate(Carbon $date, FrequencyEnum $frequency): Carbon
    {
        return $frequency->addToDate($date);
    }
}
