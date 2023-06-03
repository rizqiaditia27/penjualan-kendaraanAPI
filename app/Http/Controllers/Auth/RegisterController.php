<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;


class RegisterController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function __invoke(Request $request): JsonResponse
    {

        $data = $request->only([
            'nama',
            'email',
            'password'
        ]);

        $result = ['status'=> 200];

        try {
            $result['data'] = $this->userService->addUser($data);

        } catch(Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json([
            $result
        ],$result['status']);
      
    }
}
