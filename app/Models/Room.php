<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $guarded = [];

    public $timestamps = true;

    protected $casts = [
        "img" => 'array'
    ];
    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(RequestRoom::class, 'booking_room', 'room_id', 'booking_id');
    }

    public function roomCategories(): BelongsToMany
    {
        return $this->belongsToMany(RoomCategories::class, 'room_has_category', 'room_id', 'room_category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($room) {
            if ($room->isDirty('name') && !empty($room->img)) {
                $oldName = $room->getOriginal('name');
                $newName = $room->name;

                if (is_array($room->img)) {
                    foreach ($room->img as $key => $imagePath) {
                        if (Str::contains($imagePath, $oldName)) {
                            $newPath = str_replace($oldName, $newName, $imagePath);

                            if (Storage::exists($imagePath)) {
                                Storage::move($imagePath, $newPath);
                                $room->img[$key] = $newPath;
                            }
                        }
                    }
                }
            }
        });
    }
}
