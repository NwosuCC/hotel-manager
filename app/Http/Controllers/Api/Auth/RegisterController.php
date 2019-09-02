<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{

  public function register(Request $request)
  {
    $this->validator($request->all())->validate();

    $user = $this->create($request->all());

    return response()->json($user, 200);
  }


  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);
  }


  protected function create(array $data)
  {
    return User::query()->create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'slug' => Str::slug($data['name']),
    ]);
  }

}
