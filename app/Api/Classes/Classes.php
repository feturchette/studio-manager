<?php

namespace App\Api\Classes;

use App\Api\Booking\Booking;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'capacity',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
