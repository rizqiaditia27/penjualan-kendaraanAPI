<?php
declare(strict_types=1);

namespace App\Http\Controllers;

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

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
