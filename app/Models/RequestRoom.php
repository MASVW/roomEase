<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestRoom extends Model
{
    /** @use HasFactory<\Database\Factories\RequestRoomFactory> */
    use HasFactory;

    protected $table = 'bookings';


    protected $fillable = [
        'title',
        "description",
        "start",
        "end",
        "status",
        "user_id",
        "room_id"
    ];

    protected $dates = ['start', 'end'];

    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }


}
