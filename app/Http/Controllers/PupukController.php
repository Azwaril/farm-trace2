<?php

namespace App\Http\Controllers;

use App\Models\Pupuk;
use Illuminate\Http\Request;

class PupukController extends Controller
{

    // ===============================
    // GET semua pupuk
    // ===============================
    public function index()
    {
        $data = Pupuk::all();

        return response()->json([
            'message' => 'Data pupuk berhasil diambil',
            'data' => $data
        ],200);
    }


    // ===============================
    // POST pupuk (ADMIN ONLY)
    // ===============================
    public function store(Request $request)
    {
        $user = auth('api')->user();

        if ($user->role != 'admin') {
            return response()->json([
                'message' => 'Akses ditolak, hanya admin'
            ],403);
        }

        $request->validate([
            'nama_pupuk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $url = null;

        if ($request->hasFile('image')) {

            $result = $request->file('image')
                ->storeOnCloudinary('farm-trace/pupuk');

            $url = $result->getSecurePath();
        }

        $pupuk = Pupuk::create([
            'nama_pupuk' => $request->nama_pupuk,
            'deskripsi' => $request->deskripsi,
            'image' => $url
        ]);

        return response()->json([
            'message' => 'Pupuk berhasil ditambahkan',
            'data' => $pupuk
        ],201);
    }


    // ===============================
    // GET detail pupuk
    // ===============================
    public function show($id)
    {
        $pupuk = Pupuk::findOrFail($id);

        return response()->json([
            'message' => 'Detail pupuk',
            'data' => $pupuk
        ],200);
    }


    // ===============================
    // UPDATE pupuk (ADMIN ONLY)
    // ===============================
    public function update(Request $request, $id)
    {
        $user = auth('api')->user();

        if ($user->role != 'admin') {
            return response()->json([
                'message' => 'Akses ditolak, hanya admin'
            ],403);
        }

        $pupuk = Pupuk::findOrFail($id);

        $request->validate([
            'nama_pupuk' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $url = $pupuk->image;

        if ($request->hasFile('image')) {

            $result = $request->file('image')
                ->storeOnCloudinary('farm-trace/pupuk');

            $url = $result->getSecurePath();
        }

        $pupuk->update([
            'nama_pupuk' => $request->nama_pupuk ?? $pupuk->nama_pupuk,
            'deskripsi' => $request->deskripsi ?? $pupuk->deskripsi,
            'image' => $url
        ]);

        return response()->json([
            'message' => 'Pupuk berhasil diperbarui',
            'data' => $pupuk
        ],200);
    }


    // ===============================
    // DELETE pupuk (ADMIN ONLY)
    // ===============================
    public function destroy($id)
    {
        $user = auth('api')->user();

        if ($user->role != 'admin') {
            return response()->json([
                'message' => 'Akses ditolak, hanya admin'
            ],403);
        }

        $pupuk = Pupuk::findOrFail($id);

        $pupuk->delete();

        return response()->json([
            'message' => 'Data pupuk berhasil dihapus'
        ],200);
    }
}