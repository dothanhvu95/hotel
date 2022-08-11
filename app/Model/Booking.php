<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $guarded = [];
    protected $appends = ['money_total'];
    protected $casts = [
       // 'check_in' => 'datetime',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function getMoneyTotalAttribute()
    {
        return $this->number_day * $this->price;
    }

    public function user()
    {
       return $this->belongsTo(\App\User::class);
    }
}
