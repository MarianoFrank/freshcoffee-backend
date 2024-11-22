<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{

   public function login(LoginRequest $request)
   {
      $validated = $request->validated();

      $credentials = ["email" => $validated['email'], "password" => $validated['password']];

      if (!$validationData = auth()->validate($credentials)) {
         return response()->json(
            [
               'message' => 'Incorrect credentials',
               'errors' => ['credentials' => 'The provided credentials are incorrect.'],
               'type' => 'credentials'
            ],
            422
         );
      }
      //contiene los tokens
      return $validationData;
   }

   public function register(RegisterRequest $request)
   {
      $validated = $request->validated();

      $user = User::create([
         "name" => $validated["name"],
         "email" => $validated["email"],
         "password" => bcrypt($validated["password"]),
      ]);

      return [
         'user' => $user
      ];
   }

   public function refreshToken()
   {
      return auth()->refreshToken();
   }

   // public function logoutFromAllDevices()
   // {
   //    if (auth()->check()) {
   //       $user = auth()->user();

   //       $user->logout_all = now();

   //       $user->save();

   //       return response()->json(['message' => 'Logged out from all devices'], 200);
   //    }
   //    return response()->json(['message' => 'Usuario no autenticado.'], 401);

   // }

   public function forgotPassword(Request $request)
   {
      $request->validate(['email' => 'required|email']);

      $status = Password::sendResetLink(
         $request->only('email')
      );

      return $status === Password::RESET_LINK_SENT
         ? ['status' => __($status)]
         : ['email' => __($status)];
   }

   public function resetPassword(Request $request)
   {
      $request->validate([
         'token' => 'required',
         'email' => 'required|email',
         'password' => 'required|min:8|confirmed',
      ]);

      $status = Password::reset(
         $request->only('email', 'password', 'password_confirmation', 'token'),
         function (User $user, string $password) {
            $user->forceFill([
               'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
         }
      );

      return $status === Password::PASSWORD_RESET
         ? ['status', __($status)]
         : ['email' => [__($status)]];
   }
}
