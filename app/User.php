<?php

namespace App;

use App\Models\Booking;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
  use Notifiable;
  use HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];


  // For Passport Auth Token granted at Login
  public static function tokenName() {
    return env('APP_TOKEN_NAME') ?? 'Hotel Manager Personal Token';
  }


  public function isAdmin()
  {
    return $this->{'role'} === 'admin';
  }


  public function scopeAdmin($query)
  {
    return qs($query)->where('role','admin');
  }


  public function scopeNotAdmin($query)
  {
    return qs($query)->where('role', '!=', 'admin');
  }


  public function bookings()
  {
    return $this->hasMany( Booking::class);
  }


  // This auth user may have made some bookings as a Guest (this is allowed)
  // On login, retrieve and associate such bookings with this user
  public function attachGuestBookings()
  {
    $userBookingsAsGuest = Booking::query()->by($this)->get();

    return $userBookingsAsGuest->each(function(Booking $booking){
      $booking->user()->associate($this)->save();
    });
  }

}
