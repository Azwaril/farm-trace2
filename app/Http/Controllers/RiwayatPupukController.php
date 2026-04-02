<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPupuk;
use App\Models\Penanaman;
use Illuminate\Http\Request;

class RiwayatPupukController extends Controller
{

    // ===============================
    // GET semua riwayat pupuk
    // ===============================
    public function index()
    {
        $user = auth('api')->user();

        if ($user->role == 'admin') {

            $data = RiwayatPupuk::with(['penanaman.lahan','pupuk'])
                        ->latest()
                        ->get();

        } else if ($user->role == 'petani') {

            $data = RiwayatPupuk::whereHas('penanaman.lahan', function ($query) use ($user) {
                        $query->where('users_id', $user->id);
                    })
                    ->with(['penanaman','pupuk'])
                    ->latest()
                    ->get();

        } else {

            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        return response()->json([
            'message' => 'Data riwayat pupuk berhasil diambil',
            'data' => $data
        ],200);
    }


    // ===============================
    // POST riwayat pupuk
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
            'penanaman_id' => 'required|exists:penanaman,id',
            'pupuk_id' => 'required|exists:pupuk,id',
            'tanggal_pemupukan' => 'required|date',
            'dosis' => 'required|numeric'
        ]);

        $penanaman = Penanaman::with('lahan')->findOrFail($request->penanaman_id);

        // Petani hanya boleh menambahkan di lahannya sendiri
        if ($user->role == 'petani' && $penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

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


    // ===============================
    // GET detail riwayat pupuk
    // ===============================
    public function show($id)
    {
        $user = auth('api')->user();

        $data = RiwayatPupuk::with(['penanaman.lahan','pupuk'])->findOrFail($id);

        if ($user->role == 'petani' && $data->penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        if ($user->role == 'konsumen') {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        return response()->json([
            'message' => 'Detail riwayat pupuk',
            'data' => $data
        ],200);
    }


    // ===============================
    // UPDATE riwayat pupuk
    // ===============================
    public function update(Request $request, $id)
    {
        $user = auth('api')->user();

        $data = RiwayatPupuk::with('penanaman.lahan')->findOrFail($id);

        if ($user->role == 'konsumen') {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        if ($user->role == 'petani' && $data->penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $request->validate([
            'tanggal_pemupukan' => 'sometimes|date',
            'dosis' => 'sometimes|numeric',
            'pupuk_id' => 'sometimes|exists:pupuk,id'
        ]);

        $data->update($request->only([
            'pupuk_id',
            'tanggal_pemupukan',
            'dosis'
        ]));

        return response()->json([
            'message' => 'Riwayat pupuk berhasil diperbarui',
            'data' => $data
        ],200);
    }


    // ===============================
    // DELETE riwayat pupuk
    // ===============================
    public function destroy($id)
    {
        $user = auth('api')->user();

        $data = RiwayatPupuk::with('penanaman.lahan')->findOrFail($id);

        if ($user->role == 'konsumen') {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        if ($user->role == 'petani' && $data->penanaman->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $data->delete();

        return response()->json([
            'message' => 'Data riwayat pupuk berhasil dihapus'
        ],200);
    }
}