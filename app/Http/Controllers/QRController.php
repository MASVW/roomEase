<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Service\QRService;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function download($id)
    {
        // Retrieve the room record
        $room = Room::findOrFail($id);

        // Generate the QR code
        $qrService = new QRService();
        $url = config('app.url') . "/detail-room/{$room->id}";
        $qrCodeData = $qrService->generate($url);

        // Create a filename based on the room name
        $filename = 'room-' . preg_replace('/[^A-Za-z0-9\-]/', '', $room->name) . '.png';

        // Return the QR code image as a download response
        return response($qrCodeData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
