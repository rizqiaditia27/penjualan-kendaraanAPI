<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;



class UserService {

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function addUser(Request $request): Model {
        
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'password' => 'required|string|min:8',
        ]);

        $result = $this->userRepository->save($data);

        return $result;
    }

    public function login(Request $request): array {

        $data = $request->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if auth failed
        if(!$token = auth()->attempt($data)) {
            throw new \Exception('Login gagal');
        }

        return [
            'user'    => auth()->user(),    
            'token'   => $token   
        ];
    }
    
}

?>