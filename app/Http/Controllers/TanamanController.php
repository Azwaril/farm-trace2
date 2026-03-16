<?php

namespace App\Http\Controllers;

use App\Models\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TanamanController extends Controller
{
    // GET semua tanaman
    public function index()
    {
        $data = Tanaman::all();

        return response()->json([
            'message' => 'Data tanaman berhasil diambil',
            'data' => $data
        ], 200);
    }

    // POST tambah tanaman
    public function store(Request $request)
    {
        $request->validate([
            'nama_tanaman' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tanaman', 'public');
        }

        $tanaman = Tanaman::create([
            'nama_tanaman' => $request->nama_tanaman,
            'deskripsi' => $request->deskripsi,
            'image' => $path
        ]);

        return response()->json([
            'message' => 'Tanaman berhasil ditambahkan',
            'data' => $tanaman
        ], 201);
    }

    // UPDATE tanaman
    public function update(Request $request, $id)
    {
        $tanaman = Tanaman::findOrFail($id);

        $request->validate([
            'nama_tanaman' => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = $tanaman->image;

        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($tanaman->image) {
                Storage::disk('public')->delete($tanaman->image);
            }

            $path = $request->file('image')->store('tanaman', 'public');
        }

        $tanaman->update([
            'nama_tanaman' => $request->nama_tanaman ?? $tanaman->nama_tanaman,
            'deskripsi' => $request->deskripsi ?? $tanaman->deskripsi,
            'image' => $path
        ]);

        return response()->json([
            'message' => 'Tanaman berhasil diperbarui',
            'data' => $tanaman
        ], 200);
    }

    // DELETE tanaman
    public function destroy($id)
    {
        $tanaman = Tanaman::findOrFail($id);

        // hapus gambar
        if ($tanaman->image) {
            Storage::disk('public')->delete($tanaman->image);
        }

        $tanaman->delete();

        return response()->json([
            'message' => 'Data tanaman berhasil dihapus'
        ], 200);
    }
}