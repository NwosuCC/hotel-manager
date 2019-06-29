<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;


class BookingsController extends Controller
{

  public function index()
  {
    // ToDo
    // If Admin :: can view allbookings
    // If User :: can view only his bookings

    $bookings = Booking::query()
      ->with('room.roomType', 'user')
      ->latest()
      ->get();

    return response()->json( $bookings );
  }


  public function paginate()
  {
    $bookings = Booking::query()
      ->filter(request(['month', 'year']))
      ->with('room.roomType', 'user')
      ->latest()
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

    // ToDo: Create user and save the booking against the new User account. Makes future editing possible
//    /** @var User $user */
//    $user = User::query()->create([
//      'email' => $data['customer_email'],
//      'name' => $data['customer_full_name'],
//      'password' => bcrypt( $data['customer_email'] . microtime(true))
//    ]);

    $booking = $room->bookings()->save( Booking::query()->make( $data ) );

    return response()->json( $booking );
  }


  public function show(Booking $booking)
  {
    return response()->json( $booking );
  }


  public function update(BookingRequest $request, Booking $booking)
  {
//    $this->authorize('update', $booking);

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
//    $this->authorize('delete', $booking);

    $booking->delete();

    return response()->json(['message' => 'Booking has been deleted']);
  }
  
}
