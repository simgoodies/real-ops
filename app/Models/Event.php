<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Event extends Model
{
    use Sluggable, BelongsToTenant;

    protected $fillable = ['tenant_id', 'title', 'description', 'slug', 'start_date', 'start_time', 'end_date', 'end_time'];
    protected $dates = ['start_date', 'start_time', 'end_date', 'end_time'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function bookables()
    {
        return $this->hasMany(Bookable::class);
    }
}
