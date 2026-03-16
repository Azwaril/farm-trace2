<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPupuk;
use Illuminate\Http\Request;

class RiwayatPupukController extends Controller
{

    public function index()
    {
        $data = RiwayatPupuk::with(['penanaman','pupuk'])->latest()->get();

        return response()->json([
            'message' => 'Data riwayat pupuk berhasil diambil',
            'data' => $data
        ],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penanaman_id' => 'required|exists:penanaman,id',
            'pupuk_id' => 'required|exists:pupuk,id',
            'tanggal_pemupukan' => 'required|date',
            'dosis' => 'required|numeric'
        ]);

        $data = RiwayatPupuk::create([
            'penanaman_id' => $request->penanaman_id,
            'pupuk_id' => $request->pupuk_id,
            'tanggal_pemupukan' => $request->tanggal_pemupukan,
            'dosis' => $request->dosis
        ]);

        return response()->json([
            'message' => 'Riwayat pupuk berhasil ditambahkan',
            'data' => $data
        ],201);
    }

    public function show($id)
    {
        $data = RiwayatPupuk::with(['penanaman','pupuk'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail riwayat pupuk',
            'data' => $data
        ],200);
    }

    public function update(Request $request, $id)
    {
        $data = RiwayatPupuk::findOrFail($id);

        $request->validate([
            'penanaman_id' => 'sometimes|exists:penanaman,id',
            'pupuk_id' => 'sometimes|exists:pupuk,id',
            'tanggal_pemupukan' => 'sometimes|date',
            'dosis' => 'sometimes|numeric'
        ]);

        $data->update($request->only([
            'penanaman_id',
            'pupuk_id',
            'tanggal_pemupukan',
            'dosis'
        ]));

        return response()->json([
            'message' => 'Riwayat pupuk berhasil diperbarui',
            'data' => $data
        ],200);
    }

    public function destroy($id)
    {
        $data = RiwayatPupuk::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Data riwayat pupuk berhasil dihapus'
        ],200);
    }
}