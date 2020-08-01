<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Parental\HasChildren;
use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    use HasChildren;

    protected $fillable = [
        'event_id',
        'type',
        'begin_date',
        'begin_time',
        'end_date',
        'end_time',
        'data'
    ];
    protected $dates = ['begin_date', 'begin_time', 'end_date', 'end_time'];
    protected $casts = ['data' => 'array'];

    protected $childTypes = [
        'flight' => BookableFlight::class,
    ];

    public function booked_by()
    {
        return $this->belongsTo(Booker::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function isBooked()
    {
        return (boolean)$this->booked_by_id || (boolean)$this->booked_at;
    }

    public function getConfirmationUrl(Booker $booker)    {
        return URL::signedRoute('bookings.store', [
            'booker' => $booker,
            'bookable' => $this,
        ]);
    }
}
