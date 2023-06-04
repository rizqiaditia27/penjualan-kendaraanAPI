<?php

namespace Tests\Unit\Services;

use App\Models\Kendaraan;
use App\Models\Penjualan;
use App\Models\User;
use Mockery;
use App\Services\PenjualanService;
use App\Repositories\PenjualanRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request; 
use App\Services\UserService;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class PenjualanServiceTest extends TestCase
{
    
    protected $repository;
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        // Create a mock of Penjualan repo
        $this->repository = Mockery::mock(PenjualanRepository::class);

        // Create service
        $this->service = new PenjualanService($this->repository);
        
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testAddPenjualan_WithValidData_ShouldReturnModel()
    {

        //login terlebih dahulu untuk testing add penjualan karena nama admin dicatat

        // Create a mock of user repo
        $UserRepository = Mockery::mock(UserRepository::class);

        // Create service
        $userService = new UserService($UserRepository);

        // Create a mock request with valid credentials
        $request = Request::create('/login', 'POST', [
            'email' => "halo@email.com",
            'password' => 'password123',
        ]);
        // Call the login method
        $userService->login($request);

        $data = [
            'kendaraan_id' => '647b32564f3f8a8d660ca963',
            'total_transaksi' => 10000000,
            'catatan' => 'diskon 10%',
            'admin' => 'tes user', //sesuai data login sblmnya
        ];

        $this->repository->shouldReceive('save')
        ->once()
        ->with($data)
        ->andReturn(new Penjualan());

        $result = $this->service->addPenjualan($data);

        // // Assert that the result is an instance of the expected model class
         $this->assertInstanceOf(Penjualan::class, $result);
    }

    public function testAddPenjualan_WithInvalidData_ShouldThrowException()
    {
        $data = [
            'kendaraan_id' => '647b32564f3f8a8d660ca963',
            'total_transaksi' => 10000000,
            'catatan' => '', //required
            'admin' => 'tes user', 
        ];

        // Define the expectation for the repository save method to not be called
        $this->repository->shouldReceive('save')->never();

        // Expect an InvalidArgumentException to be thrown
        $this->expectException(InvalidArgumentException::class);
     
        $this->service->addPenjualan($data);
    }

    public function testGetPenjualan_WithoutId_ShouldReturnAllData()
    {
        // Create a mock request object with no ID
        $request = Request::create('/penjualan', 'GET');

        // Set up the expected result
        $expectedData = new collection([
            [
            'kendaraan_id' => '647b32564f3f8a8d660ca963',
            'total_transaksi' => 10000000,
            'catatan' => 'diskon 10%',
            'admin' => 'tes user',
            ],

            [
                'kendaraan_id' => '647b32564f3f8a8d660ca963',
                'total_transaksi' => 15000000,
                'catatan' => 'diskon 10%',
                'admin' => 'tes user', 
            ]
        ]); // Example data
        $expectedJumlah = count($expectedData);
        
        // Mock the penjualanRepository and define its behavior
        $this->repository->shouldReceive('getAll')
        ->once()
        ->andReturn($expectedData);

        // Call the getPenjualan method
        $result = $this->service->getPenjualan($request);

        // Assert that the result matches the expected data and jumlah
        $this->assertEquals($expectedData, $result['data']);
        $this->assertEquals($expectedJumlah, $result['jumlah']);
    }

    
    public function testGetPenjualan_WithId_ShouldReturnSingleData()
    {
        // Create a mock request object with an ID
        $request = Request::create('/penjualan', 'GET', ['id' => '123']);

        // Set up the expected result
        $expectedData = new collection([
            'kendaraan_id' => '123',
            'total_transaksi' => 10000000,
            'catatan' => 'diskon 10%',
            'admin' => 'tes user', 
        ]); // Example data
        $expectedJumlah = count($expectedData);

        // Mock the penjualanRepository and define its behavior
        $this->repository->shouldReceive('getById')
            ->once()
            ->with('123') // Ensure the correct ID is passed
            ->andReturn($expectedData);

        // Call the getPenjualan method
        $result = $this->service->getPenjualan($request);

        // Assert that the result matches the expected data and jumlah
        $this->assertEquals($expectedData, $result['data']);
        $this->assertEquals($expectedJumlah, $result['jumlah']);
    }

    
}
