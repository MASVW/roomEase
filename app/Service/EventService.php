<?php

namespace App\Service;

use App\Models\Calendar;
use App\Models\RequestRoom;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\isEmpty;

class EventService
{
    /**
     * @param $id
     * @return Collection
     */
    public function upcomingEvent($id): Collection
    {
        $nextBooking = Calendar::where('room_id', $id)
            ->where('start', '>', Carbon::now())
            ->orderBy('start', 'asc')
            ->get();

        if ($nextBooking->isEmpty()){
            return collect([]);
        }
        return $nextBooking;
    }

    /**
     * @param $id
     * @return string
     */

        public function ongoingEvent($id): string
    {
        $currentBooking = Calendar::where('room_id', $id)
            ->where('start', '<=', Carbon::now())
            ->where('end', '>=', Carbon::now())
            ->orderBy('start', 'asc')
            ->first();

        if ($currentBooking) {
            return "Ongoing Event : " . $currentBooking->title;
        }

        return "No Ongoing Events";
    }
}
