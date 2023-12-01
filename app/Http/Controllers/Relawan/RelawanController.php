<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Penduduk;
use App\Models\Pendukung;
use App\Models\Quickcount;
use App\Service\IndonesiaAreaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RelawanController extends Controller {
    /**
     * Display a listing of the resource.
     */

    private Pendukung $pendukung;
    private Penduduk $penduduk;

    public function __construct(Pendukung $pendukung, Penduduk $penduduk) {
        $this->pendukung = $pendukung;
        $this->penduduk = $penduduk;
    }

    public function dashboard() {
        return view('pages.relawan.index');
    }

    public function index() {
        try {
            return view('pages.relawan.pendukung.index');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $perPage = $request->get('perPage', 10);
            $query = $request->get('query');

            if ($query != '') {
                $data = $this->pendukung->where('user_id', Auth::user()->id)->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('kec', 'like', '%' . $query . '%')
                        ->orWhere('usia', 'like', '%' . $query . '%')
                        ->orWhere('rt', 'like', '%' . $query . '%')
                        ->orWhere('rw', 'like', '%' . $query . '%')
                        ->orWhere('desa', 'like', '%' . $query . '%');
                })
                    ->paginate($perPage);
            } else {
                $data = $this->pendukung->where('user_id', Auth::user()->id)->paginate($perPage);
            }

            $totalRow = $data->count();
            if ($totalRow > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $row->name . '
                        </th>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->usia . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->desa . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->kec . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->rt . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->rw . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->tps->name . '
                        </td>
                        <td class="flex items-center gap-x-2 px-6 py-4">
                            <a href="/dashboard/relawan/pendukung/edit/' . $row->id . '" class="flex justify-center items-center rounded bg-yellow-600 p-2">
                                <i class="bx bxs-pencil text-xl leading-none text-white"></i>
                            </a>
                            <a href="#" onclick="handleDelete(' . $row->id . ')" class="flex justify-center items-center rounded bg-red-600 p-2">
                                <i class="bx bxs-trash text-xl leading-none text-white"></i>
                            </a>
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

     public function searchPenduduk(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $perPage = $request->get('perPage', 10);
            $query = $request->get('query');

            if ($query != '') {
                $data = $this->penduduk->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('kec', 'like', '%' . $query . '%')
                        ->orWhere('usia', 'like', '%' . $query . '%')
                        ->orWhere('rt', 'like', '%' . $query . '%')
                        ->orWhere('rw', 'like', '%' . $query . '%')
                        ->orWhere('desa', 'like', '%' . $query . '%');
                })
                    ->paginate($perPage);
            } else {
                $data = $this->penduduk->paginate($perPage);
            }

            $totalRow = $data->count();
            if ($totalRow > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $row->name . '
                        </th>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->usia . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->desa . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->kec . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->rt . '
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            ' . $row->rw . '
                        </td>
                        <td class="flex items-center gap-x-2 px-6 py-4">
                            <button type="submit" onclick="handleCreate(' . $row->id . ')" class="flex justify-center items-center rounded bg-yellow-600 p-2">
                                <i class="bx bxs-pencil text-xl leading-none text-white"></i>
                            </button>
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


    public function create() {
        return view('pages.relawan.pendukung.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $penduduk = $this->penduduk->find($request->id);
            if(!$penduduk) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Penduduk not found',
                ], 404);
            }
            $response = $this->pendukung->create([
                'name' => $penduduk->name,
                'usia' => $penduduk->usia,
                'desa' => $penduduk->desa,
                'kec' => $penduduk->kec,
                'rt' => $penduduk->rt,
                'rw' => $penduduk->rw,
                'tps_id' => $request->tps_id,
                'user_id' => $request->user_id,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Pendukung created successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $pendukung = $this->pendukung->find($id);
        return view('pages.relawan.pendukung.show', compact('pendukung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $pendukung = $this->pendukung->find($id);
        return view('pages.relawan.pendukung.edit', compact('pendukung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        try {
            $validateRequest = $request->validate([
                'name' => 'required',
                'nik' => 'required|numeric',
                'kec' => 'required',
                'desa' => 'required',
                'detail_alamat' => 'nullable',
                'user_id' => 'required',
                'tps_id' => 'required',
            ]);

            $validateRequest['kec'] = IndonesiaAreaService::getArea('district', $validateRequest['kec']);
            $validateRequest['desa'] = IndonesiaAreaService::getArea('village', $validateRequest['desa']);

            $pendukung = $this->pendukung->find($id);
            $pendukung->update($validateRequest);

            return response()->json([
                'status' => 'success',
                'message' => 'Pendukung updated successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        try {

            $deleted = $this->pendukung->find($id);
            if (!$deleted) {
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
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    
}
