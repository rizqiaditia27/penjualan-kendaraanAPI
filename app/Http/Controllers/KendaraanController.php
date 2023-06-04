<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Services\KendaraanService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;



class KendaraanController extends Controller
{
    protected $kendaraanService;

    public function __construct(KendaraanService $kendaraanService)
    {
        $this->kendaraanService = $kendaraanService;
    }

    public function index(Request $request): JsonResponse
    {
        
        try{

            $result = $this->kendaraanService->getKendaraan($request);
        }catch(Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json([$result],200);
    }

    public function store(Request $request): JsonResponse
    {

        $data = $request->only([
            'tahun',
            'warna', 
            'harga' ,
            'tipe' ,
            'mesin', 
            'suspensi' ,
            'transmisi', 
            'kapasitas_penumpang',
            'tipe_mobil',
        ]);

        
        $result = ['status'=> 201];

        try {
            $result['data'] = $this->kendaraanService->addKendaraan($data);

        } catch(Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json([
            $result
        ],$result['status']);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->only([
            'tahun',
            'warna', 
            'harga' ,
            'tipe' ,
            'mesin', 
            'suspensi' ,
            'transmisi', 
            'kapasitas_penumpang',
            'tipe_mobil',
        ]);

        $result = ['status'=> 200];

        try {
            $result['data'] = $this->kendaraanService->updateKendaraan($data,$id);

        } catch(Exception $e) {
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }

        return response()->json([
            $result
        ],$result['status']);
    }

    public function destroy($id): JsonResponse
    {
        $kendaraan = Kendaraan::find($id);

        if ($kendaraan) {
            $kendaraan->delete();
            return response()->json([],204);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'],404);
        }

    }
}
