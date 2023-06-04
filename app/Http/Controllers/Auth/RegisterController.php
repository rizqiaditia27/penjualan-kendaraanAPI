<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
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
            $result['data'] = $this->userService->addUser($request);

        } catch(ValidationException $e) {
            $result = [
                'status' => 500,
                'error' => $e->errors()
            ];
        }catch (Exception $e) {
            
            if ($e->getCode() == 11000) {
                $result['error'] = 'Email sudah terdaftar';
                // ...
            } else {
                $result['errors'] = $e->getMessage();
            }

        } 

        return response()->json([
            $result
        ],$result['status']);
      
    }
}
