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

    public function index(Request $request) {
        try {
            // $perPage = $request->input('per_page', 1);
            // $admin = $this->user->where('role', 0)->get();
            $relawan = $this->user->where('role', 1)->paginate(10);
            return view('pages.admin.relawan.index', compact('relawan'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
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
        $pendukung = Pendukung::paginate(10);

        return view('pages.admin.pendukung', compact('pendukung'));
    }
}
