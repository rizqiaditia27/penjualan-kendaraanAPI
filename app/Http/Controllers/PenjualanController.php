<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Services\PenjualanService;
use Exception;
use Illuminate\Http\JsonResponse;


class PenjualanController extends Controller
{
    protected $penjualanService;

    public function __construct(PenjualanService $penjualanService)
    {
        $this->penjualanService = $penjualanService;
    }

    public function index(Request $request):JsonResponse
    {
        try{
            $result = $this->penjualanService->getPenjualan($request);
        }catch(Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json([$result],200);
    }

    public function store(Request $request):JsonResponse
    {
        $data = $request->only([
            'kendaraan_id',
            'total_transaksi', 
            'catatan' 
        ]);
        $result = ['status'=> 201];

        try {
            $result['data'] = $this->penjualanService->addPenjualan($data);

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

  
    public function show($id)
    {
        
    }

    public function update(Request $request, $id):JsonResponse
    {
        $data = $request->only([
            'total_transaksi', 
            'catatan' 
        ]);

        $result = ['status'=> 200];

        try {
            $result['data'] = $this->penjualanService->updatePenjualan($data,$id);

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


    public function destroy($id):JsonResponse
    {
        $penjualan = Penjualan::find($id);

        if ($penjualan) {
            $penjualan->delete();
            return response()->json([],204);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'],404);
        }
    }
}
