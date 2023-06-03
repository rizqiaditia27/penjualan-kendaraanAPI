<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Penjualan;
use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB;

class PenjualanRepository {

    protected $penjualan;

    public function __construct(Penjualan $penjualan)
    {
        $this->penjualan = $penjualan;
    }

    public function save($data): Model
    {
        
        $penjualan = new Penjualan();
        $penjualan->kendaraan_id     = $data['kendaraan_id'];
        $penjualan->total_transaksi    = $data['total_transaksi'];
        $penjualan->catatan   = $data['catatan'];
        $penjualan->admin    = $data['admin'];
        $penjualan->save();

        return $penjualan->fresh();
    }

    public function getAll(): Collection
    {
        return Penjualan::all();
    }

    public function getById($id): Collection{
        return Penjualan::where('kendaraan_id', $id)->get();
    }

    public function getCount(): int
    {
        return Penjualan::count();
    }
    public function getCountById($id): int
    {
        return Penjualan::where('kendaraan_id', $id)->count();
    }

}

?>