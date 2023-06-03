<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    
    public function __invoke(Request $request)
    {
        auth()->logout();
        return response()->json(['message' => "logout berhasil"]);
    }
}
