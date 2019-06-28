<?php

namespace App\Http\Controllers\Api;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class RoomTypesController extends Controller
{

    public function index()
    {
      $room_types = RoomType::query()->latest()->get();

      return response()->json( $room_types );
    }


    public function paginate()
    {
      $room_types = RoomType::query()->latest()->paginate(2);

      return RoomTypeResource::collection( $room_types );
    }


    public function store(Request $request)
    {
      $this->authorize('create', RoomType::class);

      $data = $request->only('name');

      $validator = Validator::make( $data, [
        'name' => [
          'required', 'string', Rule::unique('room_types', 'name')
        ],
      ]);

      if($validator->fails()){
        abort(400, $validator->errors()->toJson());
      }

      $room_type = RoomType::query()->create( $data );

      return response()->json( $room_type );
    }


    public function show(RoomType $room_type)
    {
      return response()->json( $room_type );
    }


    public function update(Request $request, RoomType $room_type)
    {
      $this->authorize('update', $room_type);

      $data = $request->only('name');

      $validator = Validator::make( $data, [
        'name' => [
          'required', 'string',
          Rule::unique('room_types', 'name')->whereNot('id', $room_type->{'id'})
        ],
      ]);

      if($validator->fails()){
        abort(400, $validator->errors()->toJson());
      }

      $room_type->fill( $data )->save();

      return response()->json( $room_type );
    }


    public function destroy(RoomType $room_type)
    {
      $this->authorize('delete', $room_type);


      if($room_type->rooms()->count()){
        $error = 'Please, delete or re-assign rooms under this Room Type before delete it';
        abort(400, $error);
      }

      $room_type->delete();

      return response()->json(['message' => 'Room Type has been deleted']);
    }

}
