<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Pendukung;
use App\Models\User;
use Dotenv\Validator;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller {
    /**
     * Display a listing of the resource.
     */

    private User $user;
    private Pendukung $pendukung;

    public function __construct(User $user, Pendukung $pendukung) {
        $this->user = $user;
        $this->pendukung = $pendukung;
    }

    public function index() {
        try {
            return view('pages.admin.relawan.index');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function searchRelawan(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $perPage = $request->get('perPage', 10);
            $query = $request->get('query');

            if ($query != '') {
                $data = $this->user->where('role', 1)->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                })
                    ->paginate($perPage)
                    ->onEachSide(1);
            } else {
                $data = $this->user->where('role', 1)->paginate($perPage)->onEachSide(1);
            }

            $totalRow = $data->count();
            if ($totalRow > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $row->name . '
                        </th>
                        <td class="px-6 py-4">
                            ' . $row->email . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->pendukungs->count() . '
                        </td>
                        <td class="flex items-center gap-x-2 px-6 py-4">
                            <a href="/dashboard/admin/relawan/edit/' . $row->id . '" class="flex justify-center items-center rounded bg-yellow-600 p-2">
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

    public function dashboard() {
        $relawanCount = $this->user->where('role', 1)->count();
        $pendukungCount = $this->pendukung->count();
        $candidateCount = Candidate::count();
        $topRelawan = $this->user->where('role', 1)->withCount('pendukungs')
            ->orderByDesc('pendukungs_count')
            ->limit(5)
            ->get();

        $categories = [];
        $data = [];

        foreach ($topRelawan as $relawan) {
            $categories[] = $relawan->name;
            $data[] = $relawan->pendukungs_count;
        }

        $chartData = [
            'chart' => [
                'type' => 'bar'
            ],
            'series' => [
                [
                    'name' => 'Jumlah Pendukung',
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $categories,
            ],
        ];

        $chartJson = json_encode($chartData);

        return view('pages.admin.index', compact('relawanCount', 'pendukungCount', 'candidateCount', 'chartJson'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('pages.admin.relawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $validator = Validator($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'role' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ]);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->storeAs('public/profiles', $image->hashName());
                $post = $this->user->insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => $request->input('role'),
                    'image' => $image->hashName(),

                ]);
            } else {
                $imagePath = null;
                $post = $this->user->insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => $request->input('role'),
                    'image' => null,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Relawan created successfully',
            ]);
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
        $user = $this->user->find($id);
        // return view('pages.admin.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $user = $this->user->find($id);
        return view('pages.admin.relawan.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        try {
            $validator = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $user = $this->user->find($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($user->image !== null) {
                    Storage::delete('public/profiles/' . $user->image);
                }
                $imgName = $image->hashName();

                $imagePath = $image->storeAs('public/profiles', $imgName);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => $request->role,
                    'image' => $imgName,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => $request->role,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
            ]);
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
            $deleted = $this->user->find($id);
            if (!$deleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }

            $deleted->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function indexPendukung() {
        return view('pages.admin.pendukung');
    }

    public function searchPendukung(Request $request) {
        if ($request->ajax()) {
            $output = '';
            $perPage = $request->get('perPage', 10);
            $query = $request->get('query');

            if ($query != '') {
                $data = $this->pendukung->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('nik', 'like', '%' . $query . '%')
                        ->orWhere('detail_alamat', 'like', '%' . $query . '%')
                        ->orWhere('desa', 'like', '%' . $query . '%')
                        ->orWhere('kec', 'like', '%' . $query . '%');
                })
                    ->paginate($perPage);
            } else {
                $data = $this->pendukung->paginate($perPage);
            }

            $totalRow = $data->count();
            if ($totalRow > 0) {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="border-b odd:bg-white even:bg-gray-50">
                        <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                            ' . $row->name . '
                        </th>
                        <td class="px-6 py-4">
                            ' . $row->nik . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->detail_alamat . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->desa . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->kec . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->tps->name . '
                        </td>
                        <td class="px-6 py-4">
                            ' . $row->user->name . '
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
}
