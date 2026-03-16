<?php

namespace App\Http\Controllers;

use App\Models\Pupuk;
use Illuminate\Http\Request;

class PupukController extends Controller
{

    // ==========================
    // GET semua pupuk
    // ==========================
    public function index()
    {
        $data = Pupuk::all();

        return response()->json([
            'message' => 'Data pupuk berhasil diambil',
            'data' => $data
        ], 200);
    }

    // ==========================
    // POST pupuk
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_pupuk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('pupuk', 'public');

        }

        $pupuk = Pupuk::create([
            'nama_pupuk' => $request->nama_pupuk,
            'deskripsi' => $request->deskripsi,
            'image' => $path
        ]);

        return response()->json([
            'message' => 'Pupuk berhasil ditambahkan',
            'data' => $pupuk
        ], 201);
    }

    // ==========================
    // GET detail pupuk
    // ==========================
    public function show($id)
    {
        $pupuk = Pupuk::findOrFail($id);

        return response()->json([
            'message' => 'Detail pupuk',
            'data' => $pupuk
        ], 200);
    }

    // ==========================
    // UPDATE pupuk
    // ==========================
    public function update(Request $request, $id)
    {
        $pupuk = Pupuk::findOrFail($id);

        $request->validate([
            'nama_pupuk' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = $pupuk->image;

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('pupuk', 'public');

        }

        $pupuk->update([
            'nama_pupuk' => $request->nama_pupuk ?? $pupuk->nama_pupuk,
            'deskripsi' => $request->deskripsi ?? $pupuk->deskripsi,
            'image' => $path
        ]);

        return response()->json([
            'message' => 'Pupuk berhasil diperbarui',
            'data' => $pupuk
        ], 200);
    }

    // ==========================
    // DELETE pupuk
    // ==========================
    public function destroy($id)
    {
        $pupuk = Pupuk::findOrFail($id);

        $pupuk->delete();

        return response()->json([
            'message' => 'Data pupuk berhasil dihapus'
        ], 200);
    }
}