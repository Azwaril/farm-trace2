<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use Illuminate\Http\Request;

class PanenController extends Controller
{

    // ===============================
    // GET semua data panen
    // ===============================
    public function index()
    {
        $data = Panen::with(['penanaman','riwayat_pupuk'])->get();

        return response()->json([
            'message' => 'Data panen berhasil diambil',
            'data' => $data
        ]);
    }

    // ===============================
    // POST tambah panen
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'penanaman_id' => 'required|exists:penanaman,id',
            'riwayat_pupuk_id' => 'required|exists:riwayat_pupuk,id',
            'tanggal_panen' => 'required|date',
            'jumlah_panen' => 'required|integer',
            'satuan' => 'nullable|string'
        ]);

        $data = Panen::create([
            'penanaman_id' => $request->penanaman_id,
            'riwayat_pupuk_id' => $request->riwayat_pupuk_id,
            'tanggal_panen' => $request->tanggal_panen,
            'jumlah_panen' => $request->jumlah_panen,
            'satuan' => $request->satuan ?? 'kg'
        ]);

        return response()->json([
            'message' => 'Data panen berhasil ditambahkan',
            'data' => $data
        ],201);
    }

    // ===============================
    // GET detail panen
    // ===============================
    public function show($id)
    {
        $data = Panen::with(['penanaman','riwayat_pupuk'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail data panen',
            'data' => $data
        ]);
    }

    // ===============================
    // UPDATE panen
    // ===============================
    public function update(Request $request,$id)
    {
        $data = Panen::findOrFail($id);

        $data->update($request->all());

        return response()->json([
            'message' => 'Data panen berhasil diupdate',
            'data' => $data
        ]);
    }

    // ===============================
    // DELETE panen
    // ===============================
    public function destroy($id)
    {
        $data = Panen::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Data panen berhasil dihapus'
        ]);
    }
}