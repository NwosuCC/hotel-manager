<?php

namespace App\Models;


class Room extends Model
{
  protected $fillable = ['name', 'room_type_id'];


  public function hotel()
  {
    return $this->belongsTo( Hotel::class );
  }


  public function roomType()
  {
    return $this->belongsTo( RoomType::class);
  }

}
