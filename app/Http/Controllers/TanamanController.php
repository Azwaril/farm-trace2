<?php

namespace App\Http\Controllers;

use App\Models\Tanaman;
use Illuminate\Http\Request;

class TanamanController extends Controller
{

    // ===============================
    // GET semua tanaman
    // ===============================
    public function index()
    {
        $user = auth('api')->user();

        if ($user->role == 'admin') {
            $data = Tanaman::with('user')->latest()->get();
        } elseif ($user->role == 'petani') {
            $data = Tanaman::with('user')
                        ->where('users_id', $user->id)
                        ->latest()
                        ->get();
        } else {
            // konsumen
            $data = Tanaman::with('user')->latest()->get();
        }

        return response()->json([
            'message' => 'Data tanaman berhasil diambil',
            'data' => $data
        ],200);
    }


    // ===============================
    // POST tanaman (ADMIN & PETANI)
    // ===============================
    public function store(Request $request)
    {
        $user = auth('api')->user();

        if ($user->role == 'konsumen') {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $request->validate([
            'nama_tanaman' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $url = null;
        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('tanaman', 'public');

            $url = asset('storage/' . $path);
        }

        $tanaman = Tanaman::create([
            'users_id' => $user->id,
            'nama_tanaman' => $request->nama_tanaman,
            'deskripsi' => $request->deskripsi,
            'image' => $url
        ]);

        return response()->json([
            'message' => 'Tanaman berhasil ditambahkan',
            'data' => $tanaman
        ],201);
    }


    // ===============================
    // GET detail tanaman
    // ===============================
    public function show($id)
    {
        $tanaman = Tanaman::with('user')->findOrFail($id);

        return response()->json([
            'message' => 'Detail tanaman',
            'data' => $tanaman
        ],200);
    }


    // ===============================
    // UPDATE tanaman
    // ===============================
    public function update(Request $request, $id)
    {
        $user = auth('api')->user();

        if ($user->role == 'konsumen') {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $tanaman = Tanaman::findOrFail($id);

        // petani hanya boleh update miliknya
        if ($user->role == 'petani' && $tanaman->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $request->validate([
            'nama_tanaman' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $url = $tanaman->image;

        if ($request->hasFile('image')) {

            $result = $request->file('image')
                        ->storeOnCloudinary('farm-trace/tanaman');

            $url = $result->getSecurePath();
        }

        $tanaman->update([
            'nama_tanaman' => $request->nama_tanaman ?? $tanaman->nama_tanaman,
            'deskripsi' => $request->deskripsi ?? $tanaman->deskripsi,
            'image' => $url
        ]);

        return response()->json([
            'message' => 'Tanaman berhasil diperbarui',
            'data' => $tanaman
        ],200);
    }


    // ===============================
    // DELETE tanaman
    // ===============================
    public function destroy($id)
    {
        $user = auth('api')->user();

        if ($user->role == 'konsumen') {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $tanaman = Tanaman::findOrFail($id);

        if ($user->role == 'petani' && $tanaman->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $tanaman->delete();

        return response()->json([
            'message' => 'Data tanaman berhasil dihapus'
        ],200);
    }
}