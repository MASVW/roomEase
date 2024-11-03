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
        return $this->storeDataCalendar($initData);
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
        return RequestRoom::whereHas('rooms', function ($query) use ($roomId) {
            $query->where('id', $roomId);
        })
            ->with('rooms')
            ->get();
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

    private function storeDataCalendar($data): array
    {
        $calendar = [];
        foreach($data as $item)
        {
            $booking = RequestRoom::findOrFail($item->booking_id);
            $calendar[] = [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'title' => $booking->title,
                'start' => $booking->start,
                'end' => $booking->end,
                'color' => $this->getColorByStatus($booking->status)
            ];
        }
        return $calendar;
    }

    /**
     * @param $status
     * @return string
     */
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
