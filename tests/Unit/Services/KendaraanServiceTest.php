<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Kendaraan;
use Mockery;
use App\Services\KendaraanService;
use App\Repositories\KendaraanRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request; 
use App\Services\UserService;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Collection;


class KendaraanServiceTest extends TestCase
{

    protected $repository;
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        // Create a mock of Kendaraan repo
        $this->repository = Mockery::mock(KendaraanRepository::class);

        // Create service
        $this->service = new KendaraanService($this->repository);
        
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testAddKendaraan_WithValidData_ShouldReturnModel()
    {
        $data = [
        'tahun' => 2022,
        'warna' => 'Red',
        'harga' => 200000000,
        'tipe' => 'Mobil',
        'mesin' => 'V6',
        'kapasitas_penumpang' => 5,
        'tipe_mobil' => 'Sedan',
        'spesifikasi' => [
            'mesin' => 'V6',
            'kapasitas_penumpang' => 5,
            'tipe_mobil' => 'Sedan',
            ],
        ];

        $validatedData = $data; // Since the validation method doesn't modify the data

        $this->repository->shouldReceive('save')
            ->once()
            ->with($validatedData)
            ->andReturn(new Kendaraan());

        // Act
        $result = $this->service->addKendaraan($data);

        // Assert
        $this->assertInstanceOf(Kendaraan::class, $result);
    }

    public function testAddKendaraan_WithInvalidData_ShouldThrowException()
    {
        $data = [
            'tahun' => 2022,
            'warna' => '', //required
            'harga' => 200000000,
            'tipe' => 'Mobil',
            'mesin' => 'V6',
            'kapasitas_penumpang' => 5,
            'tipe_mobil' => 'Sedan',
            'spesifikasi' => [
                'mesin' => 'V6',
                'kapasitas_penumpang' => 5,
                'tipe_mobil' => 'Sedan',
                ],
            ];

        // Define the expectation for the repository save method to not be called
        $this->repository->shouldReceive('save')->never();

        // Expect an InvalidArgumentException to be thrown
        $this->expectException(InvalidArgumentException::class);
     
        $this->service->addKendaraan($data);
    }

    public function testGetKendaraan_WithoutType_ShouldReturnAllData()
    { 
        // Create a mock request object with no ID
        $request = Request::create('/kendaraan', 'GET');

        // Set up the expected result
        $expectedData = new collection([
            [
                'tahun' => 2022,
                'warna' => 'merah', //required
                'harga' => 200000000,
                'tipe' => 'Mobil',
                'mesin' => 'V6',
                'kapasitas_penumpang' => 5,
                'tipe_mobil' => 'Sedan',
                'spesifikasi' => [
                    'mesin' => 'V6',
                    'kapasitas_penumpang' => 5,
                    'tipe_mobil' => 'Sedan',
                    ],
            ],
            [
                'tahun' => 2022,
                'warna' => 'putih', //required
                'harga' => 200000000,
                'tipe' => 'Mobil',
                'mesin' => 'V6',
                'kapasitas_penumpang' => 5,
                'tipe_mobil' => 'Sedan',
                'spesifikasi' => [
                    'mesin' => 'V6',
                    'kapasitas_penumpang' => 5,
                    'tipe_mobil' => 'Sedan',
                    ],
            ]


        ]); // Example data
        $expectedJumlah = count($expectedData);
        
        // Mock the KendaraanRepository and define its behavior
        $this->repository->shouldReceive('getAll')
        ->once()
        ->andReturn($expectedData);

        // Call the getKendaraan method
        $result = $this->service->getKendaraan($request);

        // Assert that the result matches the expected data and jumlah
        $this->assertEquals($expectedData, $result['data']);
        $this->assertEquals($expectedJumlah, $result['jumlah']);
    }

    public function testGetKendaraan_WithId_ShouldReturnSingleData()
    {
        // Create a mock request object with an ID
        $request = Request::create('/kendaraan', 'GET', ['tipe' => 'Mobil']);

        // Set up the expected result
        $expectedData = new collection([
                'tahun' => 2022,
                'warna' => 'merah', //required
                'harga' => 200000000,
                'tipe' => 'Mobil',
                'mesin' => 'V6',
                'kapasitas_penumpang' => 5,
                'tipe_mobil' => 'Sedan',
                'spesifikasi' => [
                    'mesin' => 'V6',
                    'kapasitas_penumpang' => 5,
                    'tipe_mobil' => 'Sedan',
                ], 
        ]); // Example data
        $expectedJumlah = count($expectedData);

        // Mock the KendaraanRepository and define its behavior
        $this->repository->shouldReceive('getByType')
            ->once()
            ->with('Mobil') // Ensure the correct ID is passed
            ->andReturn($expectedData);

        // Call the getKendaraan method
        $result = $this->service->getKendaraan($request);

        // Assert that the result matches the expected data and jumlah
        $this->assertEquals($expectedData, $result['data']);
        $this->assertEquals($expectedJumlah, $result['jumlah']);
    }

}
