<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Parental\HasChildren;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

class Bookable extends Model
{
    use HasChildren, BelongsToPrimaryModel;

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
        'time-slot' => BookableTimeSlot::class,
    ];

    public function getRelationshipToPrimaryModel(): string
    {
        return 'event';
    }

    public function bookedBy()
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
