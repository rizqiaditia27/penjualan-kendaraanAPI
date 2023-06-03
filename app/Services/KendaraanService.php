<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\KendaraanRepository;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\Model;
use InvalidArgumentException;
use Illuminate\Http\Request;



class KendaraanService {

    protected $kendaraanRepository;

    public function __construct(KendaraanRepository $kendaraanRepository)
    {
        $this->kendaraanRepository = $kendaraanRepository;
    }

    public function addKendaraan($data): Model {
        
        $validator = Validator::make($data,[
            'tahun' => 'required|numeric',
            'warna' => 'required|string',
            'harga' => 'required|numeric',
            'tipe' => 'required|string',
            'mesin' => 'required',
            'suspensi' => 'string',
            'transmisi' => 'string',
            'kapasitas_penumpang' => 'numeric',
            'tipe_mobil' => 'string',
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        //cek tipe kendaraan
        if($data['tipe']=='Motor'){
            $data['spesifikasi'] = [
                'mesin' => $data['mesin'],
                'suspensi' => $data['suspensi'],
                'transmisi' => $data['transmisi'],
            ];
        } else if ($data['tipe']=='Mobil') {
            $data['spesifikasi'] = [
                'mesin' => $data['mesin'],
                'kapasitas_penumpang' => $data['kapasitas_penumpang'],
                'tipe_mobil' => $data['tipe_mobil'],
            ];
        }

        $result = $this->kendaraanRepository->save($data);

        return $result;
    }

    public function getKendaraan(Request $request): array
    {
        //cek tipe kendaraan yang ingin ditampilkan
        if($request->tipe){
            $result['jumlah'] = $this->kendaraanRepository->getCountByType($request->tipe);
            $result['data'] = $this->kendaraanRepository->getByType($request->tipe);

        } else {
            $result['jumlah'] = $this->kendaraanRepository->getCount();
            $result['data'] = $this->kendaraanRepository->getAll();
        }

        return $result;
    }

    public function getAllKendaraan(): array
    {
        $result['jumlah'] = $this->kendaraanRepository->getCount();
        $result['data'] = $this->kendaraanRepository->getAll();

        return $result;
    }
    


}

?>