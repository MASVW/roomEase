<?php

namespace Tests\Feature;

use App\Service\FormattingDateService;
use Tests\TestCase;

class FormattingDateServiceTest extends TestCase
{
    private FormattingDateService $formattingDateService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formattingDateService = new FormattingDateService();
    }

    public function test_formatting_date()
    {
        $date = '2024-11-02';
        $formattedDate = $this->formattingDateService->formattingDate($date);

        $this->assertEquals('02 November 2024', $formattedDate);
    }

    public function test_formatting_using_separator()
    {
        $date = '2024-11-02 14:30:00';
        $formattedDate = $this->formattingDateService->formattingUsingSeparator($date);

        $this->assertEquals('2024-11-02T14:30', $formattedDate);
    }

    public function test_formatting_using_time()
    {
        $date = '2024-11-02 14:30:00';
        $formattedDate = $this->formattingDateService->formattingUsingTime($date);

        $this->assertEquals('14:30, 02 November 2024', $formattedDate);
    }

    public function test_formatting_to_string()
    {
        $date = '2024-11-02 14:30:00';
        $formattedDate = $this->formattingDateService->formattingToString($date);

        $this->assertEquals('2024-11-02 14:30:00', $formattedDate);
    }

    public function test_formatting_to_string_with_duration_same_day()
    {
        $eventStart = '2024-11-02 08:00:00';
        $eventEnd = '2024-11-02 18:00:00';
        $formattedDate = $this->formattingDateService->formattingToStringWithDuration($eventStart, $eventEnd);

        $this->assertEquals('02 Nov 2024 (10 Hours)', $formattedDate);
    }

    public function test_formatting_to_string_with_duration_multiple_days()
    {
        $eventStart = '2024-11-02 08:00:00';
        $eventEnd = '2024-11-04 18:00:00';
        $formattedDate = $this->formattingDateService->formattingToStringWithDuration($eventStart, $eventEnd);

        $this->assertEquals('02 Nov 2024 (3 Days)', $formattedDate);
    }
}
