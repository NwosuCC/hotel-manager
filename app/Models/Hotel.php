<?php

namespace App\Models;


class Hotel extends Model
{

  public function rooms()
  {
    return $this->hasMany( Room::class );
  }

}
