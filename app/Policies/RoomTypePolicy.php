<?php

namespace App\Policies;

use App\User;
use App\Models\RoomType;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomTypePolicy
{
  use HandlesAuthorization;


  public function before(User $user, $ability)
  {
    if($user->isAdmin()) {
      return true;
    }
  }

  public function view(User $user, RoomType $room_type)
  {
    //
  }

  public function create(User $user)
  {
    //
  }

  public function update(User $user, RoomType $room_type)
  {
    //
  }

  public function delete(User $user, RoomType $room_type)
  {
    //
  }

  public function restore(User $user, RoomType $room_type)
  {
    //
  }

  public function forceDelete(User $user, RoomType $room_type)
  {
    //
  }

}
