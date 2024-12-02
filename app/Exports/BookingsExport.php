<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                'title' => 'Welcoming New Student 2024',
                'description' => 'Orientation event for new students batch 2024',
                'start' => '2024-11-29 09:00:00',
                'end' => '2024-11-29 12:00:00',
                'room_name' => 'LP501'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'title',
            'description',
            'start',
            'end',
            'room_name'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            2 => ['fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'E8F3FF']]]
        ];
    }
}
