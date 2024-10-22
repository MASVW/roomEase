<?php

namespace App\Service;

use App\Models\Calendar;
use App\Models\RequestRoom;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\isEmpty;

class EventService
{
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

    public function ongoingEvent($id): string
    {
        $currentBooking = Calendar::where('room_id', $id)
            ->where('start', '<=', Carbon::now())
            ->where('end', '>=', Carbon::now())
            ->orderBy('start', 'asc')
            ->first();

        if ($currentBooking) {
            return "Ongoing Event : " . $currentBooking->event_title;
        }

        return "No Ongoing Events";
    }

    //CODE BELLOW JUST FOR KEEP NO NEED TO TEST OR USE!
    /**
     * @param $id
     * @return string
     */
    public function keepUpcomingFunction($id): string
    {
        $nextBooking = RequestRoom::where('room_id', $id)
            ->where('status', 'approved')
            ->where('end_time', '>', Carbon::now())
            ->orderBy('end_time', 'asc')
            ->first();

        if ($nextBooking) {
            return "Booked At " . $nextBooking->end_time->format('d M');
        }

        return "No Upcoming Events";
    }
}
