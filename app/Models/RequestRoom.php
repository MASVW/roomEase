<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'booking_room', 'booking_id', 'room_id');
    }


}
