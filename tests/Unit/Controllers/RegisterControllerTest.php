<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;
use Exception;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;


class RegisterControllerTest extends TestCase
{
    protected $userService;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock UserService
        $this->userService = Mockery::mock(UserService::class);

        // Create an instance of the RegisterController with the mock UserService
        $this->controller = new RegisterController($this->userService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRegister_WithValidCredentials_ShouldSuccess()
    {
        // Mock the UserService's addUser method
        $this->userService->shouldReceive('addUser')->once()->andReturn(new User());

        // Create a mock Request object with the necessary data
        $request = new Request([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        // Call the register method on the controller
        $response = $this->controller->__invoke($request);
        
        // Assert the response status code is 200
        $this->assertEquals(200, $response->getStatusCode());
    }
}
