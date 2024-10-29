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
                'id' => $item->id,
                'user_id' => $item->user_id,
                'title' => $item->title,
                'start' => $item->start,
                'end' => $item->end,
                'color' => $this->getColorByStatus($item->status)
            ];
        }
        return $calendar;
    }
    private function getColorByStatus($status)
    {
        switch ($status) {
            case 'approved':
                return '#28a745';
            case 'pending':
                return '#ffc107';
            case 'rejected':
                return '#dc3545';
            default:
                return '#007bff';
        }
    }
}
