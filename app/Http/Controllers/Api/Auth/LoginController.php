<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LoginController extends Controller
{

  /** For Test purposes only */
  public function demo()
  {
    $admin = User::query()->admin()->first(['email'])->toArray();
    $admin['password'] = 'password';

    $data = [
      'admin' => $admin
    ];

    return response()->json($data, 200);
  }


  public function login()
  {
    if(auth()->attempt(request(['email', 'password']))){

      /** @var User $user */
      $user = auth()->user();

      $user->{'token'} = $user->createToken( User::tokenName() )->accessToken;

      $user->attachGuestBookings();

      return response()->json($user, 200);
    }

    abort(400, 'Incorrect username or password');
  }


  public function logout(Request $request)
  {
    auth()->guard()->logout();

    if($request->hasSession()){
      $request->session()->invalidate();
    }

    return redirect('/');
  }

}
