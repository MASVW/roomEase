<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    /** @use HasFactory<\Database\Factories\CalendarFactory> */
    use HasFactory;
    protected $table = "calendars";
    protected $guarded = [];

    protected $dates = ['start', 'end'];

    public $timestamps = true;
    public function booking(): BelongsTo
    {
        return $this->belongsTo(RequestRoom::class);
    }
}
