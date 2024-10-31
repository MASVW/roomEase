<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoomHasCategories extends Pivot
{
    protected $table = 'room_has_category';

    public $incrementing = false;

    protected $primaryKey = 'room_id';

    protected $fillable = [
        'room_id',
        'room_category_id'
    ];

    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    // Relasi ke RoomCategory
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategories::class, 'room_category_id');
    }
}
