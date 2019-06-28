<?php

namespace App\Models;


class RoomType extends Model
{

  public function hotel()
  {
    return $this->belongsTo( Hotel::class );
  }


  public function rooms()
  {
    return $this->hasMany( Room::class );
  }

}
