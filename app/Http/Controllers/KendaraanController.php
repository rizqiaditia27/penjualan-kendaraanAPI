<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Services\KendaraanService;
use Illuminate\Http\Request;
use Exception;


class KendaraanController extends Controller
{
    protected $kendaraanService;

    public function __construct(KendaraanService $kendaraanService)
    {
        $this->kendaraanService = $kendaraanService;
    }

    public function index(Request $request)
    {
        $result = $this->kendaraanService->getKendaraan($request);

        return response()->json($result,200);
    }

    public function store(Request $request)
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

    public function show($type)
    {
        
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
