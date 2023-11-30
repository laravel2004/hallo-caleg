<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller {
    /**
     * Display a listing of the resource.
     */
    private Candidate $candidate;

    public function __construct(Candidate $candidate) {
        $this->candidate = $candidate;
    }

    public function index() {
        return view('pages.admin.candidate.index');
    }

    public function search(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $perPage = $request->get('perPage', 10);
            $query = $request->get('query');

            if ($query != '') {
                $data = $this->candidate->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('partai', 'like', '%' . $query . '%')
                        ->orWhere('nomor_urut', 'like', '%' . $query . '%')
                        ->orWhere('jenis_kelamin', 'like', '%' . $query . '%')
                        ->orWhere('tempat_tinggal', 'like', '%' . $query . '%');
                })
                    ->paginate($perPage);
            } else {
                $data = $this->candidate->paginate($perPage);
            }

            $totalRow = $data->count();
            if ($totalRow > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $row->nomor_urut . '
                        </th>
                        <td class="px-6 py-4">
                            <img src="' . asset('storage/candidate/' . $row->image) . '" alt="' . $row->name . '" class="w-20 object-cover">
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->name . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->jenis_kelamin . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->partai . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->tempat_tinggal . '
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-x-2">
                                <a href="/dashboard/admin/candidate/' . $row->id . '" class="flex justify-center items-center rounded bg-primary p-2">
                                    <i class="bx bxs-info-circle text-xl leading-none text-white"></i>
                                </a>
                                <a href="/dashboard/admin/candidate/edit/' . $row->id . '" class="flex justify-center items-center rounded bg-yellow-600 p-2">
                                    <i class="bx bxs-pencil text-xl leading-none text-white"></i>
                                </a>
                                <a href="#" onclick="handleDelete(' . $row->id . ')" class="flex justify-center items-center rounded bg-red-600 p-2">
                                    <i class="bx bxs-trash text-xl leading-none text-white"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    ';
                }
            } else {
                $output .= '
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-500">
                        Tidak ada data yang dapat ditampilkan.
                    </td>
                </tr>
                ';
            }

            $data = array(
                'table_data' => $output,
                'pagination' => $data->links('pagination::tailwind')->toHtml(),
            );

            return response()->json($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('pages.admin.candidate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'partai' => 'required',
                'nomor_urut' => 'required|numeric',
                'jenis_kelamin' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
                'tempat_tinggal' => 'required',
            ]);

            $image = $request->file('image');
            $image->storeAs('public/candidate', $image->hashName());

            $this->candidate->create([
                'name' => $request->name,
                'partai' => $request->partai,
                'nomor_urut' => $request->nomor_urut,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_tinggal' => $request->tempat_tinggal,
                'image' => $image->hashName(),
            ]);

            return redirect('dashboard/admin/candidate')->with('success', 'Data Berhasil Ditambahkan');
        } catch (Exception $e) {
            dd($e);
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        try {
            $candidate = $this->candidate->find($id);
            $quickcount = $candidate->quickcount->count();
            return view('pages.admin.candidate.show', compact('candidate', 'quickcount'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $candidate = $this->candidate->find($id);
        return view('pages.admin.candidate.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        try {
            $request->validate([
                'name' => 'required',
                'partai' => 'required',
                'nomor_urut' => 'required|numeric',
                'jenis_kelamin' => 'required',
                'tempat_tinggal' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $candidate = $this->candidate->find($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/candidate', $image->hashName());

                $response = $candidate->update([
                    'name' => $request->name,
                    'partai' => $request->partai,
                    'nomor_urut' => $request->nomor_urut,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_tinggal' => $request->tempat_tinggal,
                    'image' => $image->hashName(),
                ]);
            } else {
                $response = $candidate->update([
                    'name' => $request->name,
                    'partai' => $request->partai,
                    'nomor_urut' => $request->nomor_urut,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tempat_tinggal' => $request->tempat_tinggal,
                ]);
            }
            if ($response) {
                return redirect('dashboard/admin/candidate')->with('success', 'Data Berhasil Diubah');
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        try {
            $candidate = $this->candidate->find($id);
            Storage::delete('public/candidate' . $candidate->image);
            $candidate->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
