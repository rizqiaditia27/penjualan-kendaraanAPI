<?php

namespace Tests\Unit\Repositories;

use App\Models\Kendaraan;
use App\Repositories\KendaraanRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class KendaraanRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    protected $kendaraanRepository;
    protected $kendaraan;
    //fake data
    protected $initialData = [
            'tahun' => 2022,
            'warna' => 'Merah',
            'harga' => 250000000,
            'tipe' => 'Mobil',
            'spesifikasi' => [
                'mesin' => '2500 cc',
                'kapasitas_penumpang' => 7,
                'tipe_mobil' => 'SUV'
            ],
    ];
    
    public function setUp(): void
    {
        parent::setUp();

        // Create a new instance of KendaraanRepository
        $this->kendaraanRepository = new KendaraanRepository(new Kendaraan());

        // Save the initial data
        $this->kendaraan = $this->kendaraanRepository->save($this->initialData);
    }



    //tes apakah data Kendaraan bisa disave 
    public function testSaveKendaraan()
    {
       
        // Assert that the kendaraan was saved successfully
        $this->assertInstanceOf(kendaraan::class, $this->kendaraan);
        $this->assertEquals($this->initialData['tahun'], $this->kendaraan->tahun);
        $this->assertEquals($this->initialData['warna'], $this->kendaraan->warna);
        $this->assertEquals($this->initialData['harga'], $this->kendaraan->harga);
        $this->assertEquals($this->initialData['tipe'], $this->kendaraan->tipe);
        $this->assertEquals($this->initialData['spesifikasi'], $this->kendaraan->spesifikasi);
        $this->assertEquals($this->initialData['spesifikasi']['mesin'], $this->kendaraan->spesifikasi['mesin']);
        $this->assertEquals($this->initialData['spesifikasi']['kapasitas_penumpang'], $this->kendaraan->spesifikasi['kapasitas_penumpang']);
        $this->assertEquals($this->initialData['spesifikasi']['tipe_mobil'], $this->kendaraan->spesifikasi['tipe_mobil']);
    }

    public function testUpdateKendaraan()
    {     
        // update initial data data
        $data = [
            'tahun' => 2022,
            'warna' => 'putih',
            'harga' => 300000000,
            'tipe' => 'Mobil',
            'spesifikasi' => [
                'mesin' => '2500 cc',
                'kapasitas_penumpang' => 7,
                'tipe_mobil' => 'SUV'
            ],
        ];

        // Save the data
        $this->kendaraanRepository->update($data, $this->kendaraan);

        // Assert update sukses
        $this->assertInstanceOf(kendaraan::class, $this->kendaraan);
        $this->assertEquals($data['tahun'], $this->kendaraan->tahun);
        $this->assertEquals($data['warna'], $this->kendaraan->warna);
        $this->assertEquals($data['harga'], $this->kendaraan->harga);
        $this->assertEquals($data['tipe'], $this->kendaraan->tipe);
        $this->assertEquals($data['spesifikasi'], $this->kendaraan->spesifikasi);
        $this->assertEquals($data['spesifikasi']['mesin'], $this->kendaraan->spesifikasi['mesin']);
        $this->assertEquals($data['spesifikasi']['kapasitas_penumpang'], $this->kendaraan->spesifikasi['kapasitas_penumpang']);
        $this->assertEquals($data['spesifikasi']['tipe_mobil'], $this->kendaraan->spesifikasi['tipe_mobil']);
    }

    public function testGetAll()
    {

        //create another data
        Kendaraan::create([
            'tahun' => 2020,
            'warna' => 'putih',
            'harga' => 30000000,
            'tipe' => 'Motor',
            'spesifikasi' => [
                'mesin' => '250 cc',
                'suspensi' => 'single shock',
                'transmisi' => 'matic'
            ],
        ]);

        $result = $this->kendaraanRepository->getAll();

        // Assert that the result is a collection of Kendaraan models
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertTrue($result->every(function ($item) {
            return $item instanceof Kendaraan;
        }));
    }

    public function testGetByType()
    {
        //create another data
        $data = Kendaraan::create([
            'tahun' => 2020,
            'warna' => 'putih',
            'harga' => 30000000,
            'tipe' => 'Motor',
            'spesifikasi' => [
                'mesin' => '250 cc',
                'suspensi' => 'single shock',
                'transmisi' => 'matic'
            ],
        ]);
        
        //get data by id
        $result = $this->kendaraanRepository->getByType($data->tipe);

        // Assert that the result is a collection
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);

        // Assert that the result contains the expected kendaraan model
        $this->assertTrue($result->contains(function ($item) use ($data) {
            return $item instanceof Kendaraan && $item->id === $data->id;
        }));
    }

}
