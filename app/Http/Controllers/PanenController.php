<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Penanaman;
use Illuminate\Http\Request;

class PanenController extends Controller
{

    // ===============================
    // GET semua data panen
    // ===============================
    public function index()
    {
        $user = auth('api')->user();

        if ($user->role == 'admin') {

            $data = Panen::with(['penanaman','riwayat_pupuk'])->get();

        } else {

            $data = Panen::whereHas('penanaman.lahan', function ($query) use ($user) {
                $query->where('users_id', $user->id);
            })->with(['penanaman','riwayat_pupuk'])->get();
        }

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

        $user = auth('api')->user();

        $penanaman = Penanaman::with('lahan')->findOrFail($request->penanaman_id);

        // Petani hanya boleh panen dari lahannya sendiri
        if ($user->role == 'petani' && $penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

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
        $user = auth('api')->user();

        $data = Panen::with(['penanaman.lahan','riwayat_pupuk'])->findOrFail($id);

        if ($user->role == 'petani' && $data->penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

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
        $user = auth('api')->user();

        $data = Panen::with('penanaman.lahan')->findOrFail($id);

        if ($user->role == 'petani' && $data->penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $request->validate([
            'tanggal_panen' => 'required|date',
            'jumlah_panen' => 'required|integer',
            'satuan' => 'nullable|string'
        ]);

        $data->update([
            'tanggal_panen' => $request->tanggal_panen,
            'jumlah_panen' => $request->jumlah_panen,
            'satuan' => $request->satuan ?? $data->satuan
        ]);

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
        $user = auth('api')->user();

        $data = Panen::with('penanaman.lahan')->findOrFail($id);

        if ($user->role == 'petani' && $data->penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $data->delete();

        return response()->json([
            'message' => 'Data panen berhasil dihapus'
        ]);
    }
}