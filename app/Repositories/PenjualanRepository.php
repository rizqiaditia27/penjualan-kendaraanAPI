<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

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

    public function update($data, $penjualan): Model
    {
        $penjualan->update($data);

        return $penjualan->fresh();
    }

    public function getAll(): Collection
    {
        return Penjualan::all();
    }

    public function getById($id): Collection { 
        return Penjualan::where('kendaraan_id', $id)->get();
    }

}

?>