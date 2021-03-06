<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Booking;
use App\User;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;


class BookingsController extends Controller
{

  protected function bookings()
  {
    // ToDo
    // If Admin :: can view allbookings
    // If User :: can view only his bookings

    /** @var User $user */
    $user = auth()->user();

    $bookings = Booking::query()
      ->with('room.roomType', 'user')
      ->latest();

    return $user->isAdmin() ? $bookings : $bookings->by($user);
  }


  public function index()
  {
    return response()->json( $this->bookings()->get() );
  }


  public function paginate()
  {
    $bookings = $this->bookings()
      ->filter(request(['month', 'year']))
      ->paginate(5);

    return BookingResource::collection( $bookings );
  }


  public function store(BookingRequest $request)
  {
    $this->authorize('create', Booking::class);

    $data = $request->only(
      'room_id', 'start_date', 'end_date', 'customer_full_name', 'customer_email'
    );

    $start_date = Carbon::parse( $data['start_date'] );
    $end_date = Carbon::parse( $data['end_date'] );

    /** @var Room $room */
    $room = Room::query()->find( $data['room_id'] );

    $data['total_nights'] = $end_date->diffInDays( $start_date );
    $data['current_price'] = $room->{'roomType'}->price;
    $data['total_price'] = $data['current_price'] * $data['total_nights'];

    /**n @var Booking $booking */
    $booking = $room->bookings()->save(
      Booking::query()->make( $data )
    );

    if($user = auth()->user()){
      $booking->user()->associate($user)->save();
    }

    return response()->json( $booking );
  }


  public function show(Booking $booking)
  {
    return response()->json( $booking );
  }


  public function update(BookingRequest $request, Booking $booking)
  {
    try {
      $this->authorize('update', $booking);
    }
    catch (\Exception $e){
      return noAuthError();
    }

    $data = $request->only(
      'room_id', 'start_date', 'end_date', 'customer_full_name', 'customer_email'
    );

    $start_date = Carbon::parse( $data['start_date'] );
    $end_date = Carbon::parse( $data['end_date'] );

    /** @var Room $room */
    $room = Room::query()->find( $data['room_id'] );

    $data['total_nights'] = $end_date->diffInDays( $start_date );
    $data['current_price'] = $room->{'roomType'}->price;
    $data['total_price'] = $data['current_price'] * $data['total_nights'];

    $booking->fill( $data )->save();

    return response()->json( $booking );
  }


  public function destroy(Booking $booking)
  {
    $this->authorize('delete', $booking);

    $booking->delete();

    return response()->json(['message' => 'Booking has been deleted']);
  }

}
