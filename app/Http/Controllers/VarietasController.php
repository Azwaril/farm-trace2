<?php

namespace App\Http\Controllers;

use App\Models\Varietas;
use Illuminate\Http\Request;

class VarietasController extends Controller
{
    // GET semua varietas
    public function index()
    {
        $data = Varietas::with('tanaman')->get();

        return response()->json([
            'message' => 'Data varietas berhasil diambil',
            'data' => $data
        ]);
    }

    // POST tambah varietas
    public function store(Request $request)
    {
        $request->validate([
            'tanaman_id' => 'required|exists:tanaman,id',
            'nama_varietas' => 'required|string|max:255'
        ]);

        $data = Varietas::create([
            'tanaman_id' => $request->tanaman_id,
            'nama_varietas' => $request->nama_varietas
        ]);

        return response()->json([
            'message' => 'Varietas berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    // GET detail varietas
    public function show($id)
    {
        $data = Varietas::with('tanaman')->findOrFail($id);

        return response()->json([
            'message' => 'Detail varietas',
            'data' => $data
        ]);
    }

    // UPDATE varietas
    public function update(Request $request, $id)
    {
        $varietas = Varietas::findOrFail($id);

        $request->validate([
            'tanaman_id' => 'required|exists:tanaman,id',
            'nama_varietas' => 'required|string|max:255'
        ]);

        $varietas->update([
            'tanaman_id' => $request->tanaman_id,
            'nama_varietas' => $request->nama_varietas
        ]);

        return response()->json([
            'message' => 'Varietas berhasil diperbarui',
            'data' => $varietas
        ]);
    }

    // DELETE varietas
    public function destroy($id)
    {
        $varietas = Varietas::findOrFail($id);
        $varietas->delete();

        return response()->json([
            'message' => 'Data varietas berhasil dihapus'
        ]);
    }
}