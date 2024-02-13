<?php

namespace App\Http\Controllers\Quickcount;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Quickcount;
use App\Models\TPS;
use App\Service\IndonesiaAreaService;
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
        return view('pages.relawan.quickcount.index');
    }

    public function search(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $perPage = $request->get('perPage', 10);
            $query = $request->get('query');

            $quickcounts = $this->quickcount->all();

            if ($query != '') {
                $data = $this->candidate->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('partai', 'like', '%' . $query . '%')
                        ->orWhere('nomor_urut', 'like', '%' . $query . '%');
                })
                    ->paginate($perPage);
            } else {
                $data = $this->candidate->paginate($perPage);
            }
            $totalRow = $data->count();
            if ($totalRow > 0) {
                foreach ($data as $row) {
                    $vote = 0;
                    foreach($quickcounts as $quickcount) {
                        if($quickcount->candidate_id === $row->id) {
                            $vote += $quickcount->total;
                        }
                    }

                    $output .= '
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <td class="px-6 py-4">
                            <img src="' . asset('storage/candidate/' . $row->image) . '" alt="' . $row->name . '" class="w-20 object-cover">
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->name . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->partai . '
                        </td>
                        <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $row->nomor_urut . '
                        </td>
                        <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $vote . '
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-x-2">
                                <a href="/dashboard/relawan/quickcount/' . $row->id . '" class="flex justify-center items-center rounded bg-yellow-600 p-2">
                                    <i class="bx bxs-pencil text-xl leading-none text-white"></i>
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
    public function vote(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $perPage = $request->get('perPage', 10);
            $query = $request->get('query');

            $quickcounts = $this->quickcount->all();

            if ($query != '') {
                $data = $this->candidate->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('partai', 'like', '%' . $query . '%')
                        ->orWhere('nomor_urut', 'like', '%' . $query . '%');
                })
                    ->paginate($perPage);
            } else {
                $data = $this->candidate->paginate($perPage);
            }
            $totalRow = $data->count();
            if ($totalRow > 0) {
                foreach ($data as $row) {
                    $vote = 0;
                    foreach($quickcounts as $quickcount) {
                        if($quickcount->candidate_id === $row->id) {
                            $vote += $quickcount->total;
                        }
                    }

                    $output .= '
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <td class="px-6 py-4">
                            <img src="' . asset('storage/candidate/' . $row->image) . '" alt="' . $row->name . '" class="w-20 object-cover">
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->name . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->partai . '
                        </td>
                        <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $row->nomor_urut . '
                        </td>
                        <td scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $vote . '
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-x-2">
                                <a href="/dashboard/relawan/quickcount/' . $row->id . '" class="flex justify-center items-center rounded bg-yellow-600 p-2">
                                    <i class="bx bxs-pencil text-xl leading-none text-white"></i>
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
            $isExist = $this->tps->where('id', $validateRequest['tps_id'])->get();

            if($isExist->count() > 0) {
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
            ], 400);
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
        $profile = $this->candidate->find($id);
        $vote = 0;
        foreach($data as $item) {
            $vote += $item->total;
        }
        if(!$data->isEmpty()) {
            $kecamatan = $data->pluck('tps_id')->toArray();
            $tps = $this->tps->whereIn('id', $kecamatan)->get();
            $desa = [];
            if(!$tps->isEmpty()) {
                foreach($tps as $tp) {
                    $desa[] =IndonesiaAreaService::getArea('village', $tp->village_id);
                }
                return view('pages.relawan.quickcount.show', compact('profile', 'tps', 'desa', 'id', 'vote'));
            }
        }
        return view('pages.relawan.quickcount.show', compact('profile', 'id'));

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
