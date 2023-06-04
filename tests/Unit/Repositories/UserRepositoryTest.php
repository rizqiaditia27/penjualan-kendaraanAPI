<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    //use DatabaseMigrations;

    //tes apakah data user bisa disave 
    public function testSaveUser()
    {
        // Generate fake data
        //data ini digunakan untuk testing login
        $data = [
            'nama' => "tes user",
            'email' => "halo@email.com",
            'password' => 'password123',
        ];

        // Create a new instance of UserRepository
        $userRepository = new UserRepository(new User());

        // Save the user
        $user = $userRepository->save($data);

        // Assert that the user was saved successfully
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($data['nama'], $user->nama);
        $this->assertEquals($data['email'], $user->email);
        $this->assertTrue(Hash::check($data['password'], $user->password));
    }
}
