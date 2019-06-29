<?php

namespace App\Models;


use App\User;
use Illuminate\Support\Carbon;


class Booking extends Model
{
  protected $fillable = [
    'room_id', 'start_date', 'end_date', 'customer_full_name', 'customer_email',
    'current_price', 'total_nights', 'total_price'
  ];

  protected $dates = ['start_date', 'end_date'];

  protected $appends = ['is_active'];


  public function getIsActiveAttribute()
  {
    return $this->{'start_date'}->isPast();
  }


  public function room()
  {
    return $this->belongsTo( Room::class );
  }


  public function user()
  {
    return $this->belongsTo( User::class );
  }


  public function scopeFilter($query, $filters)
  {
    if($month = $filters['month'] ?? ''){
      qs($query)->whereMonth('start_date', Carbon::parse($month)->month);
    }

    if($year = $filters['year'] ?? ''){
      qs($query)->whereYear('start_date', $year);
    }
  }


}
