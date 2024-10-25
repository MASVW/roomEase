<?php

namespace App\Service;

use Carbon\Carbon;

class FormattingDateService
{
    public function formattingDate($date): string
    {
        return Carbon::parse($date)->format('d F Y');
    }
    public function formattingUsingSeparator($date): string
    {
        return Carbon::parse($date)->format('Y-m-d\TH:i');;
    }
    public function formattingToString($date): string
    {
        return Carbon::parse($date)->toDateTimeString();
    }
}
