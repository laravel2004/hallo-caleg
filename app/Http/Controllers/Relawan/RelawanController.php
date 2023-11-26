<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Pendukung;
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
            if($request->ajax()) {
                $data = $this->pendukung->where('user_id', $user->id)->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pendukung', function($row){
                    return $row->name.','.$row->nik.','.$row->desa.','.$row->kec.','.$row->detail_alamat.','.$row->tps->name;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('relawan.address.edit', $row->id) . '" class="btn btn-success edit"><i class="bi bi-pencil-square"></i></a>
                    <button onclick="handleDelete(' . $row->id . ')" class="btn btn-danger delete"><i class="bi bi-trash"></i></button>';
                        return $actionBtn;
                })->toJson();
            }
            return view('pages.relawan.index');
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
        return view('pages.relawan.create');
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
        return view('pages.relawan.show', compact('pendukung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pendukung = $this->pendukung->find($id);
        return view('pages.relawan.edit', compact('pendukung'));
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
