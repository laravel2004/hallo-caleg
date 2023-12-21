<?php

namespace App\Http\Controllers\Quickcount;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Quickcount;
use App\Models\TPS;
use Exception;
use Illuminate\Http\Request;

class QuickcountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private Quickcount $quickcount;
    private Candidate $candidate;
    private TPS $tps;

    public function __construct(Quickcount $quickcount, Candidate $candidate, TPS $tps) {
        $this->quickcount = $quickcount;
        $this->candidate = $candidate;
        $this->tps = $tps;
    }

    public function index()
    {
        $quickcounts = $this->quickcount->all();
        $candidates = $this->candidate->all();
        return view('pages.relawan.quickcount.index', compact('quickcounts', 'candidates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validateRequest = $request->validate([
                'candidate_id' => 'required',
                'total' => 'required',
                'tps_id' => 'required',
            ]);

            $isExist = $this->tps->find($validateRequest['tps_id']);
            if(!$isExist) {
                $this->quickcount->create([
                    'candidate_id' => $validateRequest['candidate_id'],
                    'total' => $validateRequest['total'],
                    'tps_id' => $validateRequest['tps_id'],
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Berhasil ditambah',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Data TPS sudah ada',
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->quickcount->where('candidate_id', $id)->get();
        return view('pages.relawan.quickcount.show', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quickcount = $this->candidate->find($id);
        return view('pages.relawan.quickcount.edit', compact('quickcount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validateRequest = $request->validate([
                'candidate_id' => 'required',
                'total' => 'required',
                'tps_id' => 'required',
            ]);

            $quickcount = $this->tps->find($validateRequest['tps_id']);
            $quickcount->update([
                'candidate_id' => $validateRequest['candidate_id'],
                'total' => $validateRequest['total'],
                'tps_id' => $validateRequest['tps_id'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data Berhasil diupdate',
            ]);

        }
        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
