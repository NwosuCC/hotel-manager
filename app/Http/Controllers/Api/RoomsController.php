<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use Illuminate\Support\Facades\Validator;


class RoomsController extends Controller
{

  public function index()
  {
    $rooms = Room::query()->with('roomType')->latest()->get();

    return response()->json( $rooms );
  }


  public function paginate()
  {
    $rooms = Room::query()->with('roomType')->latest()->paginate(4);

    return RoomResource::collection( $rooms );
  }


  public function store(Request $request)
  {
    $this->authorize('create', Room::class);

    $data = $request->only('name', 'hotel_id', 'room_type_id');

    $validator = Validator::make( $data, $this->rules());

    if($validator->fails()){
      abort(400, $validator->errors()->toJson());
    }

    /** @var Hotel $hotel */
    $hotel = Hotel::query()->find( $data['hotel_id'] );

    $room = $hotel->rooms()->save( Room::query()->make( $data ) );

    return response()->json( $room );
  }


  public function show(Room $room)
  {
    return response()->json( $room );
  }


  public function update(Request $request, Room $room)
  {
    $this->authorize('update', $room);

    $data = $request->only('name', 'hotel_id', 'room_type_id');

    $validator = Validator::make( $data, $this->rules($room));

    if($validator->fails()){
      abort(400, $validator->errors()->toJson());
    }

    $room->fill( $data )->save();

    return response()->json( $room );
  }


  public function destroy(Room $room)
  {
    $this->authorize('delete', $room);

    $room->delete();

    return response()->json(['message' => 'Room has been deleted']);
  }


  protected function rules(Room $room = null)
  {
    return [
      'name' => [
        Rule::unique('rooms', 'name')->whereNot('id', $room ? $room->{'id'} : '')
      ],
      'hotel_id' => [
        'required', Rule::exists('hotels', 'id')
      ],
      'room_type_id' => [
        'required', Rule::exists('room_types', 'id')
      ],
    ];
  }
  
}
