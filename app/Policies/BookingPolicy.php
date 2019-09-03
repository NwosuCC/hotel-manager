<?php

namespace App\Policies;

use App\User;
use App\Models\Booking;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
  use HandlesAuthorization;


  public function before(User $user, $ability)
  {
    //
  }

  public function view(User $user, Booking $booking)
  {
    //
  }

  public function create(User $user)
  {
    return true;
  }

  public function update(User $user, Booking $booking)
  {
    dd($user->{'id'} === $booking->{'user'}->id, $user->toArray(), $booking->toArray());
    return $user->{'id'} === $booking->{'user'}->id;
  }

  public function delete(User $user, Booking $booking)
  {
    return $user->isAdmin() || ($user->{'id'} === $booking->{'user'}->id);
  }

  public function restore(User $user, Booking $booking)
  {
    //
  }

  public function forceDelete(User $user, Booking $booking)
  {
    //
  }

}
