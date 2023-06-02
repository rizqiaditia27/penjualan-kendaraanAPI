<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService;
use Exception;


class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request)
    {

        $data = $request->only([
            'email',
            'password'
        ]);

        $result = ['status'=> 200];
        try {
            $result['data'] = $this->userService->login($data);

        } catch(Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        //if auth success
        return response()->json([
            $result,
            $result['status']
        ]);
    }
}
