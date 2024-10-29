<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class AuthController extends Controller
{
   public function logout(Request $request)
   {


      return auth()->logout();
   }

   public function logoutFromAllDevices()
   {
      if (auth()->check()) {
         $user = auth()->user();

         $user->logout_all = now();

         $user->save();

         return response()->json(['message' => 'Logged out from all devices'], 200);
      }
      return response()->json(['message' => 'Usuario no autenticado.'], 401);

   }

   public function login(LoginRequest $request)
   {
      $validated = $request->validated();


      $credentials = ["email" => $validated['email'], "password" => $validated['password']];

      if (!$validationData = auth()->validate($credentials)) {
         return response()->json(['error' => 'Unauthorized'], 401);
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


}
