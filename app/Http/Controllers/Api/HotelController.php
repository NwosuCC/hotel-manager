<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{

  public function index()
  {
    $hotel = Hotel::query()->first();

    return response()->json( $hotel );
  }

}
