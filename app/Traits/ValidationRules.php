<?php

namespace App\Traits;

trait ValidationRules
{
    public static function timeRangeValidation()
    {
        return function ($attribute, $value, $fail) {
            $time = strtotime($value);
            $hour = date('H', $time);
            $minute = date('i', $time);
            if (($hour < 9 && $minute < 60) || ($hour >= 21)) {
                $fail($attribute . ' is out of the allowed time range.');
            }
        };
    }

}
