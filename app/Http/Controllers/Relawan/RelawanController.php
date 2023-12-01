<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Pendukung;
use App\Models\Quickcount;
use App\Service\IndonesiaAreaService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RelawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private Pendukung $pendukung;

    public function __construct(Pendukung $pendukung) {
        $this->pendukung = $pendukung;
    }


    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $pendukung = $this->pendukung->where('user_id', $user->id)->get();
            return view('pages.relawan.pendukung.index', compact('pendukung'));
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.relawan.pendukung.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try{
            $validateRequest = $request->validate([
                'name' => 'required',
                'nik' => 'required',
                'kec' => 'required',
                'desa' => 'required',
                'detail_alamat' => 'nullable',
                'user_id' => 'required',
                'tps_id' => 'required',
            ]);
            $validateRequest['kec'] = IndonesiaAreaService::getArea('district' ,$validateRequest['kec']);
            $validateRequest['desa'] = IndonesiaAreaService::getArea('village' ,$validateRequest['desa']);

            
            $pendukung = $this->pendukung->create($validateRequest);
            return response()->json([
                'status' => 'success',
                'message' => 'Pendukung created successfully',
            ], 201);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pendukung = $this->pendukung->find($id);
        return view('pages.relawan.pendukung.show', compact('pendukung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pendukung = $this->pendukung->find($id);
        return view('pages.relawan.pendukung.edit', compact('pendukung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validateRequest = $request->validate([
                'name' => 'required',
                'nik' => 'required',
                'kec' => 'required',
                'desa' => 'required',
                'detail_alamat' => 'nullable',
                'user_id' => 'required',
                'tps_id' => 'required',
            ]);

            $pendukung = $this->pendukung->find($id);
            $this->pendukung->update($pendukung, $validateRequest);

            return response()->json([
                'status' => 'success',
                'message' => 'Pendukung updated successfully',
            ], 200);

        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            
            $deleted = $this->pendukung->find($id);
            if(!$deleted){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pendukung not found',
                ], 404);
            }

            $deleted->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Pendukung deleted successfully',
            ], 200);

        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    
}
