<?php

namespace Tests\Unit\Repositories;

use App\Models\Penjualan;
use App\Repositories\PenjualanRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PenjualanRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    protected $penjualanRepository;
    protected $penjualan;
    //fake data
    protected $initialData = [
        'kendaraan_id' => "647b32564f3f8a8d660ca963",
        'total_transaksi' => "15000000",
        'catatan' => 'diskon 50%',
        'admin' => 'rizqi'
    ];

    public function setUp(): void
    {
        parent::setUp();

        // Create a new instance of penjualanRepository
        $this->penjualanRepository = new PenjualanRepository(new Penjualan());

        // Save the initial data
        $this->penjualan = $this->penjualanRepository->save($this->initialData);
    }

    //tes apakah data penjualan bisa disave 
    public function testSavePenjualan()
    {

        // Assert that the penjualan was saved successfully
        $this->assertInstanceOf(Penjualan::class, $this->penjualan);
        $this->assertEquals($this->initialData['kendaraan_id'], $this->penjualan->kendaraan_id);
        $this->assertEquals($this->initialData['total_transaksi'], $this->penjualan->total_transaksi);
        $this->assertEquals($this->initialData['catatan'], $this->penjualan->catatan);
        $this->assertEquals($this->initialData['admin'], $this->penjualan->admin);
    }

    public function testUpdatePenjualan()
    {
        
        // Generate fake data
        $updateData = [
            'kendaraan_id' => "647b32564f3f8a8d660ca963",
            'total_transaksi' => "10000000",
            'catatan' => 'diskon 60%',
            'admin' => 'rizqi'
        ];

        // Save the data
        $this->penjualanRepository->update($updateData, $this->penjualan);
        

        // Assert that the penjualan was saved successfully
        $this->assertInstanceOf(Penjualan::class, $this->penjualan);
        $this->assertEquals($updateData['kendaraan_id'], $this->penjualan->kendaraan_id);
        $this->assertEquals($updateData['total_transaksi'], $this->penjualan->total_transaksi);
        $this->assertEquals($updateData['catatan'], $this->penjualan->catatan);
        $this->assertEquals($updateData['admin'], $this->penjualan->admin);
    }

    public function testGetAll() {

        //create another data
        Penjualan::create([
            'kendaraan_id' => 2,
            'total_transaksi' => 20000000,
            'catatan' => 'diskon 10%',
            'admin' => 'admin 2',
        ]);

        $result= $this->penjualanRepository->getAll();

        // Assert that the result is a collection of Penjualan models
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertTrue($result->every(function ($item) {
            return $item instanceof Penjualan;
        }));
    }

    public function testGetById()
    {
        //create another penjualan
        $penjualan = Penjualan::create([
            'kendaraan_id' => '647b32564f3f8a8d660ca963',
            'total_transaksi' => 10000000,
            'catatan' => 'diskon 10%',
            'admin' => 'admin',
        ]);

        $result = $this->penjualanRepository->getById($penjualan->kendaraan_id);

        // Assert that the result is a collection
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);

        // Assert that the result contains the expected penjualan model
        $this->assertTrue($result->contains(function ($item) use ($penjualan) {
            return $item instanceof Penjualan && $item->id === $penjualan->id;
        }));
    }
    
}
