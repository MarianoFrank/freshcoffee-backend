<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
   public function logout(Request $request): void {}

   public function login(Request $request): void {}

   public function register(RegisterRequest $request): void
   {
      $validated = $request->validated();
   }
}
