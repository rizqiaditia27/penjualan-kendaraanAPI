<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Kendaraan;
use Jenssegers\Mongodb\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;


class KendaraanRepository {

    protected $kendaraan;

    public function __construct(Kendaraan $kendaraan)
    {
        $this->kendaraan = $kendaraan;
    }

    public function save($data): Model
    {
        $kendaraan           = new Kendaraan();
        $kendaraan->tahun     = $data['tahun'];
        $kendaraan->warna    = $data['warna'];
        $kendaraan->harga    = $data['harga'];
        $kendaraan->tipe    = $data['tipe'];
        $kendaraan->spesifikasi    = $data['spesifikasi'];
        $kendaraan->save();

        return $kendaraan->fresh();
    }

    public function update($data,$kendaraan): Model
    {

        $kendaraan->tahun     = $data['tahun'];
        $kendaraan->warna    = $data['warna'];
        $kendaraan->harga    = $data['harga'];
        $kendaraan->tipe    = $data['tipe'];
        $kendaraan->spesifikasi    = $data['spesifikasi'];
        $kendaraan->save();

        return $kendaraan->fresh();
    }

    public function getAll(): Collection
    {
        return Kendaraan::all();
    }

    public function getByType($type): Collection{
        return Kendaraan::where('tipe', $type)->get();
    }

}

?>