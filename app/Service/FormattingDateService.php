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
        return Carbon::parse($date)->format('Y-m-d\TH:i');
    }
    public function formattingUsingTime($date): string
    {
        return Carbon::parse($date)->format('H:i, d F Y');
    }
    public function formattingToString($date): string
    {
        return Carbon::parse($date)->toDateTimeString();
    }

    public function formattingToStringWithDuration($eventStart, $eventEnd): string
    {
        $start = Carbon::parse($eventStart)->startOfDay();
        $end = Carbon::parse($eventEnd)->endOfDay();

        if ($start->isSameDay($end)) {
            $hours = Carbon::parse($eventStart)->diffInHours($eventEnd);
            $duration = "($hours Hours)";
        } else {
            $startTime = Carbon::parse($eventStart);
            $endTime = Carbon::parse($eventEnd);
            $days = $startTime->diffInDays($endTime) + 1;
            $formatted = number_format($days, 0);
            $duration = "({$formatted} Days)";
        }
        return  $start->format('d M Y') . ' ' . $duration;
    }
}
