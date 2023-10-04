<?php

namespace App\Services;

use Illuminate\Http\Request;

class TokenService {

    public function generate(Request $request): string
    {
        $user = $request->user();
        $tokenResult = $user->createToken('Person Access Token');
        $token = $tokenResult->plainTextToken;
        return $token;
    }
}