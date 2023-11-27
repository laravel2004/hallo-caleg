<?php

namespace App\Http\Controllers\OCR;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Service\OCRService;
use Dotenv\Validator;

class OCRController extends Controller
{
    public function readImage(Request $req)
    {
        try{
            $validator = Validator($req->all(), [
                'tgl_upload' => 'required',
                'file' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ]);
            }
           
            $data = OCRService::readImage($req);
            return response()->json([
                'data' => $data,
                'message' => 'retrieve data succeed!',
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 501);
        }
        // return response()->json([
        //     'status' => 'error',
        //     'message' => 'halo'
        // ], 200);
    }
}
