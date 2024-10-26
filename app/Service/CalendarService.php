<?php

namespace App\Service;

use App\Models\Calendar;
use App\Models\RequestRoom;
use App\Models\Room;
use Illuminate\Support\Collection;

class CalendarService
{
    /**
     * @return array
     */
    public function refreshDataCalendarHasApproved(): array
    {
        $initData = $this->initDataCalendarHasApproved();
        return $this->storeData($initData);
    }

    /**
     * @param $roomId
     * @return array
     */
    public function refreshDataCalendarSpecificRoom($roomId): array
    {
        $initData = $this->initDataCalendarSpecificRoom($roomId);
        return $this->storeData($initData);
    }

    /**
     * @param $roomId
     * @return Collection
     */
    private function initDataCalendarSpecificRoom($roomId): Collection
    {
        return RequestRoom::where('room_id', $roomId)->get();
    }

    /**
     * @return Collection
     */
    private function initDataCalendarHasApproved(): Collection
    {
        return Calendar::all();
    }

    /**
     * @param $data
     * @return array
     */
    private function storeData($data): array
    {
        $calendar = [];
        foreach($data as $item)
        {
            $calendar[] = [
                'title' => $item->title,
                'start' => $item->start,
                'end' => $item->end,
            ];
        }
        return $calendar;
    }
}
