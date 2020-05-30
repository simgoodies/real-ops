<?php

namespace App\Models;

use Parental\HasChildren;
use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    use HasChildren;

    protected $fillable = ['event_id', 'type', 'data'];

    protected $casts = [
        'data' => 'array',
    ];

    protected $childTypes = [
        'flight' => BookableFlight::class,
    ];


}
