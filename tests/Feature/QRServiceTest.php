<?php

namespace Tests\Feature;

use App\Service\QRService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QRServiceTest extends TestCase
{
    private QRService $qrService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->qrService = new QRService();
    }

    public function test_generate_qr_code_returns_valid_png_string()
    {
        $data = 'Hello, this is a test QR code';

        $result = $this->qrService->generate($data);

        $this->assertIsString($result);
        $this->assertStringStartsWith("\x89PNG\r\n\x1a\n", $result, 'The QR code should be a valid PNG string.');
    }
}
