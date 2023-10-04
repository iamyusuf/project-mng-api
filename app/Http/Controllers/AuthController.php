<?php

namespace App\Http\Controllers;

use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request, TokenService $tokenService)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt(request(['email', 'password']))) {
            return response()->json([
                'message' => 'Unauthorized!'
            ], 401);
        }        

        return response()->json([
            'accessToken' => $tokenService->generate($request),
            'tokenType' => 'Bearer'
        ]);
    }
}
