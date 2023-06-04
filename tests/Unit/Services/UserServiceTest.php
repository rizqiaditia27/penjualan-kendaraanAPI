<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Mockery;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Http\Request; 
use Illuminate\Validation\ValidationException;



class UserServiceTest extends \Tests\TestCase
{

    protected $repository;
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        // Create a mock of user repo
        $this->repository = Mockery::mock(UserRepository::class);

        // Create service
        $this->service = new UserService($this->repository);
        
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testAddUser_WithValidData_ShouldReturnModel()
    {
        $data = [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ];
        
        $request = Request::create('/users', 'POST', $data);

        $this->repository->shouldReceive('save')
        ->once()
        ->with($data)
        ->andReturn(new User());

        // Call the addUser method
        $result = $this->service->addUser($request);

        // // Assert that the result is an instance of the expected model class
         $this->assertInstanceOf(User::class, $result);
    }

    public function testAddUser_WithInvalidData_ShouldThrowException()
    {
        $request = Request::create('/users', 'POST', [
            'nama' => 'John Doe',
            'email' => '', // Invalid: Email is required
            'password' => 'password123',
        ]);

        // Define the expectation for the repository save method to not be called
        $this->repository->shouldReceive('save')->never();

        // Expect an InvalidArgumentException to be thrown
        $this->expectException(ValidationException::class);

        // Call the addUser method
        $this->service->addUser($request);
    }

    public function testLogin_WithValidCredentials_ShouldReturnUserAndToken()
    {
        // Create a mock request with valid credentials
         $request = Request::create('/login', 'POST', [
            'email' => "halo@email.com",
            'password' => 'password123',
        ]);
        // Call the login method
        $response = $this->service->login($request);

         // Assert that the returned array contains specific keys
        $this->assertArrayHasKey('user', $response);
        $this->assertArrayHasKey('token', $response);
    }

    public function testLogin_WithInvalidCredentials_ShouldThrowException()
    {
        // Create a mock request with valid credentials
         $request = Request::create('/login', 'POST', [
            'email' => "halo@email.com",
            'password' => 'password', //invalid password
        ]);

        // Call the login method and expect an exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Login gagal');

        // Call the login method
        $this->service->login($request);

    }
}
