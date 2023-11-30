<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Exception;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private Candidate $candidate;

    public function __construct(Candidate $candidate){
        $this->candidate = $candidate;
    }

    public function index()
    {
        $candidates = $this->candidate->all();
        return view('pages.admin.candidate.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.candidate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'partai' => 'required',
                'nomor_urut' => 'required',
                'jenis_kelamin' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'tempat_tinggal' => 'required',
            ]);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->storeAs('public/candidate', $image->hashName());
                $this->candidate->create([
                    'name' => $request->name,
                    'partai' => $request->partai,
                    'nomor_urut' => $request->nomor_urut,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_tinggal' => $request->tempat_tinggal,
                    'image' => $image->hashName(),
                ]);
            }
            else {
                $this->candidate->create([
                    'name' => $request->name,
                    'partai' => $request->partai,
                    'nomor_urut' => $request->nomor_urut,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_tinggal' => $request->tempat_tinggal,
                ]);
            }
            return redirect('dashboard/admin/candidate')->with('success', 'Data Berhasil Ditambahkan');
        }
        catch(Exception $e) {
            dd($e);
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $candidate = $this->candidate->find($id);
            $quickcount = $candidate->quickcount->count();
            return view('pages.admin.candidate.show', compact('candidate', 'quickcount'));
        }
        catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $candidate = $this->candidate->find($id);
        return view('pages.admin.candidate.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'partai' => 'required',
                'nomor_urut' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_tinggal' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $candidate = $this->candidate->find($id);

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->storeAs('public/candidate', $image->hashName());
                $response = $candidate->update([
                    'name' => $request->name,
                    'partai' => $request->partai,
                    'nomor_urut' => $request->nomor_urut,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_tinggal' => $request->tempat_tinggal,
                    'image' => $image->hashName(),
                ]);
            }
            else {
                $response = $candidate->update([
                    'name' => $request->name,
                    'partai' => $request->partai,
                    'nomor_urut' => $request->nomor_urut,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_tinggal' => $request->tempat_tinggal,
                    'image' => null,
                ]);
            }
            if($response) {
                return redirect('dashboard/admin/candidate')->with('success', 'Data Berhasil Diubah');
            }

        }
        catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleted = $this->candidate->find($id);
            $deleted->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus',
            ]);
        }
        catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
