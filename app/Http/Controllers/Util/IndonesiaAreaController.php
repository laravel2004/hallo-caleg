<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\TPS;
use App\Service\IndonesiaAreaService;
use Exception;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Facade as Indonesia;

class IndonesiaAreaController extends Controller
{
    public function province()
    {
        return Indonesia::allProvinces()->pluck('name', 'id');
    }

    public function city(Request $request)
    {
        if (is_null($request->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Provinsi tidak boleh kosong',
            ], 500);
        }
        try {
            return Indonesia::findProvince($request->id, ['cities'])->cities->pluck('name', 'id');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Provinsi tidak ditemukan',
            ], 404);
        }
    }

    public function district(Request $request)
    {
        if (is_null($request->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kota tidak boleh kosong',
            ], 500);
        }
        try {
            return Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kota tidak ditemukan',
            ], 404);
        }
    }

    public function subDistrict(Request $request)
    {
        if (is_null($request->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kecamatan tidak boleh kosong',
            ], 500);
        }
        try {
            return Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kecamatan tidak ditemukan',
            ], 404);
        }
    }

    public function getTps(Request $request) {
        if (is_null($request->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'TPS Tidak boleh kosong',
            ], 500);
        }
        try {
            $tps = TPS::where('village_id', $request->id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $tps
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'TPS tidak ditemukan',
            ], 404);
        }
    }
}
