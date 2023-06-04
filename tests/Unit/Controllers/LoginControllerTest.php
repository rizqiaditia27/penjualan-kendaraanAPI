<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;
use Exception;


class LoginControllerTest extends TestCase
{
    private $controller;
    private $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock instance of UserService
        $this->userService = Mockery::mock(UserService::class);

        // Create an instance of LoginController with the mock UserService
        $this->controller = new LoginController($this->userService);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Destroy the mock instances
        Mockery::close();
    }

    public function testLogin_WithValidCredentials_ShouldReturnUser(): void
    {
        // Create a mock request object
        $request = Request::create('/login', 'POST', [
            'email' => 'halo@gmail.com',
            'password' => 'password123'
        ]);

        // Set up the expected result
        $expectedData = ['nama' => 'tes user']; // Example data
        $expectedStatus = 200;

        // Mock the userService and define its behavior
        $this->userService->shouldReceive('login')
            ->once()
            ->with($request)
            ->andReturn($expectedData);

        // Call the __invoke method on the controller
        $response = $this->controller->__invoke($request);
        $jsonData = $response->getContent();
        $data = json_decode($jsonData, true);
        $nama = $data[0]['data']['nama'];

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($expectedStatus, $response->getStatusCode());
        $this->assertEquals($expectedData['nama'], $nama);
    }

    public function testLogin_WithInvalidCredentials_ShouldReturnError(): void
    {
        // Create a mock request object
        $request = Request::create('/login', 'POST', [
            'email' => 'halo@gmail.com',
            'password' => '12345678'
        ]);

        // Set up the expected error
        $expectedError = 'Login gagal';
        $expectedStatus = 500;

        $this->userService->shouldReceive('login')
            ->once()
            ->with($request)
            ->andThrow(new Exception($expectedError));


        // Call the __invoke method on the controller
        $response = $this->controller->__invoke($request);
        $jsonData = $response->getContent();
        $data = json_decode($jsonData, true);

        // Assertions
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($expectedStatus, $response->getStatusCode());
        $this->assertEquals($expectedError, $data[0]['error']);
    }

}
