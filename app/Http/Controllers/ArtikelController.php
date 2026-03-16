<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    // ==========================
    // GET semua artikel
    // ==========================
    public function index()
    {
        $data = Artikel::with('user')->latest()->get();

        return response()->json([
            'message' => 'Data artikel berhasil diambil',
            'data' => $data
        ], 200);
    }

    // ==========================
    // POST artikel
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('artikel', 'public');

        }

        $artikel = Artikel::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'image' => $path,
            'users_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Artikel berhasil dibuat',
            'data' => $artikel
        ], 201);
    }

    // ==========================
    // GET detail artikel
    // ==========================
    public function show($id)
    {
        $artikel = Artikel::with('user')->findOrFail($id);

        return response()->json([
            'message' => 'Detail artikel',
            'data' => $artikel
        ], 200);
    }

    // ==========================
    // UPDATE artikel
    // ==========================
    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'nullable|string|max:255',
            'isi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = $artikel->image;

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('artikel', 'public');

        }

        $artikel->update([
            'judul' => $request->judul ?? $artikel->judul,
            'isi' => $request->isi ?? $artikel->isi,
            'image' => $path
        ]);

        return response()->json([
            'message' => 'Artikel berhasil diperbarui',
            'data' => $artikel
        ], 200);
    }

    // ==========================
    // DELETE artikel
    // ==========================
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        $artikel->delete();

        return response()->json([
            'message' => 'Artikel berhasil dihapus'
        ], 200);
    }
}