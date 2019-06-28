<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LoginController extends Controller
{

  public function login()
  {
    if(auth()->attempt(request(['email', 'password']))){

      /** @var User $user */
      $user = auth()->user();

      $user->{'token'} = $user->createToken( User::tokenName() )->accessToken;

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
