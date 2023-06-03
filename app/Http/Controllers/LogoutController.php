<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    
    public function __invoke(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => "logout berhasil"]);
    }
}
