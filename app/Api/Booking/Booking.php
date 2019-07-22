<?php

namespace App\Api\Booking;

use App\Api\Classes\Classes;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date',
    ];

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
}
