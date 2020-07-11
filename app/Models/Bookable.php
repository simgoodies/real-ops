<?php

namespace App\Models;

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


}
