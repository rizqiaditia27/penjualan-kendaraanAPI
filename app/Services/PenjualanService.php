<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\PenjualanRepository;
use App\Models\Penjualan;

use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\Model;
use InvalidArgumentException;
use Illuminate\Http\Request;



class PenjualanService {

    protected $penjualanRepository;

    public function __construct(PenjualanRepository $penjualanRepository)
    {
        $this->penjualanRepository = $penjualanRepository;
    }

    public function addPenjualan($data): Model {
        
        $data = $this->validatePenjualan($data);

        $result = $this->penjualanRepository->save($data);

        return $result;
    }

    public function getPenjualan(Request $request): array
    {
        //cek tipe Penjualan yang ingin ditampilkan
        if($request->id){

            $result['jumlah'] = $this->penjualanRepository->getCountById($request->id);
            $result['data'] = $this->penjualanRepository->getById($request->id);

        } else {
            $result['jumlah'] = $this->penjualanRepository->getCount();
            $result['data'] = $this->penjualanRepository->getAll();
        }
        

        return $result;
    }
    
    public function updatePenjualan($data, $id): Model {

        $penjualan = Penjualan::find($id);

        if($penjualan)
        {
            $validatedData = $this->validatePenjualan($data);
            $result = $this->penjualanRepository->update($validatedData,$penjualan);
        } else {
            throw new \Exception("Data tidak ditemukan");
        }

        return $result;

    }

    private function validatePenjualan($data): array
    {
        $validator = Validator::make($data,[
            'total_transaksi' => 'required|numeric',
            'catatan' => 'required|string',
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        //data tambahan
        $data['admin'] =  auth()->user()->nama;

        return $data;
    }

}

?>