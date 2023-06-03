<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\Model;
use InvalidArgumentException;


class UserService {

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function addUser($data): Model {
        
        $validator = Validator::make($data,[
            'nama' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'password' => 'required|string|min:8',
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->userRepository->save($data);

        return $result;
    }

    public function login($data): array {

        $validator = Validator::make($data, [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        //if auth failed
        if(!$token = auth()->attempt($data)) {
            throw new \Exception('Login gagal');
        }

        return $result = [
            'user'    => auth()->user(),    
            'token'   => $token   
        ];
    }
    
}

?>