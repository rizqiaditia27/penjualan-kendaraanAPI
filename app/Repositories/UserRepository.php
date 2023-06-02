<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Mongodb\Eloquent\Model;


class UserRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function save($data): Model
    {
        $user           = new User();
        $user->nama     = $data['nama'];
        $user->email    = $data['email'];
        $user->password    = Hash::make($data['password']);
        $user->save();

        return $user->fresh();
    }

}

?>