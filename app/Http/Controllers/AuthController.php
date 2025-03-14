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
use Illuminate\Auth\Events\Registered;
use Firebase\JWT\JWT;

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
         "admin" => 0,
         "password" => bcrypt($validated["password"]),
      ]);

      event(new Registered($user)); //enviar email de verificación

      //Esto no lo voy a hacer, ya que no podria validar el email desde otro dispositivo
      // // Inicia sesion automaticamente, pero debe validar la cuenta
      // $token = JWT::encode([
      //    'iss' => env(" APP_URL"), // Emisor del token
      //    'sub' => $user->id,        // ID del usuario
      //    'name' => $user->name,
      //    'email' => $user->email,   // Email del usuario
      //    'admin' => $user->admin,
      //    'iat' => time(),           // Hora en que fue emitido
      //    'exp' => time() + env("JWT_EXPIRED_TIME", 86400)
      //    //'logout_all' => $user->logout_all
      // ], env('JWT_SECRET', ''), 'HS256');

      return response()->json([
         'user' => $user,
         //'access_token' => $token
      ]);
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
