<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendukung;
use App\Models\User;
use Dotenv\Validator;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private User $user;
    private Pendukung $pendukung;

    public function __construct(User $user, Pendukung $pendukung)
    {
        $this->user = $user;
        $this->pendukung = $pendukung;
    }

    public function index(Request $request)
    {
       try {
            if($request->ajax()) {
                $data = $this->user->where('role', 1)->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('count', function($row){
                    return $row->pendukungs->count();
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('customer.address.edit', $row->id) . '" class="btn btn-success edit"><i class="bi bi-pencil-square"></i></a>
                    <button onclick="handleDelete(' . $row->id . ')" class="btn btn-danger delete"><i class="bi bi-trash"></i></button>';
                        return $actionBtn;
                })->toJson();
            }
            return view('pages.admin.index');
       }
       catch(Exception $e) {
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
        return view('pages.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            } else {
                $imagePath = null;
            }

            $post = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'image' => $image->hashName(),

            ]);
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
    public function show(string $id)
    {
        $user = $this->user->find($id);
        return view('pages.admin.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->user->find($id);
        return view('pages.admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable',
                'role' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ]);
            }

            $user = $this->user->find($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($user->image) {
                    Storage::delete('public/profiles/' . $user->image);
                }

                $imagePath = $image->storeAs('public/profiles', $image->hashName());

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => $request->role,
                    'image' => $image->hashName(),
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
                'user' => $user,
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
    public function destroy(string $id)
    {
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

        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
