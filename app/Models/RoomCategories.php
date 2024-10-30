<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomCategories extends Model
{
    /** @use HasFactory<\Database\Factories\RoomCategoriesFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'room_has_category', 'room_category_id', 'room_id');
    }
}
