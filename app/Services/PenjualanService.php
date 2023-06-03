<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\PenjualanRepository;
use Carbon\Carbon;
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
        
        $validator = Validator::make($data,[
            'kendaraan_id' => 'required|string',
            'total_transaksi' => 'required|numeric',
            'catatan' => 'required|string',
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        //data tambahan
        $data['admin'] =  auth()->user()->nama;
        $data['tanggal_transaksi'] = Carbon::now();

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

    public function getAllPenjualan(): array
    {
        $result['jumlah'] = $this->penjualanRepository->getCount();
        $result['data'] = $this->penjualanRepository->getAll();

        return $result;
    }
    


}

?>