<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Kendaraan;
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
        
        $validatedData = $this->validateKendaraan($data);

        $result = $this->kendaraanRepository->save($validatedData);

        return $result;
    }

    public function getKendaraan(Request $request,): array
    {
        //cek tipe kendaraan yang ingin ditampilkan
        if($request->tipe){
            $result['data'] = $this->kendaraanRepository->getByType($request->tipe);
            
        } else {
            $result['data'] = $this->kendaraanRepository->getAll();
        }

        $result['jumlah'] = count($result['data']);

        return $result;
    }
    
    public function updateKendaraan($data, $id): Model {

        $kendaraan = Kendaraan::find($id);
        //cek apakah id valid
        if($kendaraan)
        {
            $validatedData = $this->validateKendaraan($data);
            $result = $this->kendaraanRepository->update($validatedData,$kendaraan);
        } else {
            throw new \Exception("Data tidak ditemukan");
        }

        return $result;

    }

    private function validateKendaraan($data): array{

        $validator = Validator::make($data, [
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

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $spesifikasi = [];

        if ($data['tipe'] == 'Motor') {
            $spesifikasi = [
                'mesin' => $data['mesin'],
                'suspensi' => $data['suspensi'],
                'transmisi' => $data['transmisi'],
            ];
        } else if ($data['tipe'] == 'Mobil') {
            $spesifikasi = [
                'mesin' => $data['mesin'],
                'kapasitas_penumpang' => $data['kapasitas_penumpang'],
                'tipe_mobil' => $data['tipe_mobil'],
            ];
        }

        $data['spesifikasi'] = $spesifikasi;

        return $data;
    }

}

?>