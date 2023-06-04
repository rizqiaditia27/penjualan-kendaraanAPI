<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;


class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request): JsonResponse
    {

        $result = ['status'=> 200];
        try {
            $result['data'] = $this->userService->login($request);

        } catch(Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        //if auth success
        return response()->json([
            $result
            
        ],$result['status']);
    }
}
