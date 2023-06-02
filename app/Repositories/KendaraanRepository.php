<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Kendaraan;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Mongodb\Eloquent\Model;
use Carbon\Carbon;

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
        $kendaraan->created_at = Carbon::now();
        $kendaraan->save();

        return $kendaraan->fresh();
    }

    public function getAll()
    {
        return Kendaraan::all();
    }

    public function getByType($type){
        return Kendaraan::where('tipe', $type)->get();
    }

    public function getCount()
    {
        return Kendaraan::count();
    }
    public function getCountByType($type)
    {
        return Kendaraan::where('tipe', $type)->count();
    }

}

?>