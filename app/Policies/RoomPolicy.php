<?php

namespace App\Policies;

use App\User;
use App\Models\Room;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
  use HandlesAuthorization;


  public function before(User $user, $ability)
  {
    if($user->isAdmin()) {
      return true;
    }
  }

  public function view(User $user, Room $room)
  {
    //
  }

  public function create(User $user)
  {
    //
  }

  public function update(User $user, Room $room)
  {
    //
  }

  public function delete(User $user, Room $room)
  {
    //
  }

  public function restore(User $user, Room $room)
  {
    //
  }

  public function forceDelete(User $user, Room $room)
  {
    //
  }

}
