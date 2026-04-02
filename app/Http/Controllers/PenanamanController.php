<?php

namespace App\Http\Controllers;

use App\Models\Penanaman;
use App\Models\Lahan;
use Illuminate\Http\Request;

class PenanamanController extends Controller
{

    // ===============================
    // GET semua penanaman
    // ===============================
    public function index()
    {
        $user = auth('api')->user();

        if ($user->role == 'admin') {

            $data = Penanaman::with(['lahan','tanaman','varietas'])->get();

        } else {

            $data = Penanaman::whereHas('lahan', function ($query) use ($user) {
                $query->where('users_id', $user->id);
            })->with(['lahan','tanaman','varietas'])->get();
        }

        return response()->json([
            'message' => 'Data penanaman berhasil diambil',
            'data' => $data
        ]);
    }


    // ===============================
    // POST tambah penanaman
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'tanaman_id' => 'required|exists:tanaman,id',
            'lahan_id' => 'required|exists:lahan,id',
            'varietas_id' => 'required|exists:varietas,id',
            'tanggal_tanam' => 'required|date',
            'catatan' => 'nullable|string'
        ]);

        $user = auth('api')->user();

        $lahan = Lahan::findOrFail($request->lahan_id);

        // Petani hanya boleh menanam di lahannya sendiri
        if ($user->role == 'petani' && $lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $data = Penanaman::create([
            'tanaman_id' => $request->tanaman_id,
            'lahan_id' => $request->lahan_id,
            'varietas_id' => $request->varietas_id,
            'tanggal_tanam' => $request->tanggal_tanam,
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'message' => 'Penanaman berhasil ditambahkan',
            'data' => $data
        ],201);
    }


    // ===============================
    // GET detail penanaman
    // ===============================
    public function show($id)
    {
        $user = auth('api')->user();

        $data = Penanaman::with(['lahan','tanaman','varietas'])->findOrFail($id);

        if ($user->role == 'petani' && $data->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        return response()->json([
            'message' => 'Detail penanaman',
            'data' => $data
        ]);
    }


    // ===============================
    // UPDATE penanaman
    // ===============================
    public function update(Request $request,$id)
    {
        $user = auth('api')->user();

        $data = Penanaman::with('lahan')->findOrFail($id);

        if ($user->role == 'petani' && $data->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $request->validate([
            'tanggal_tanam' => 'required|date',
            'catatan' => 'nullable|string'
        ]);

        $data->update([
            'tanggal_tanam' => $request->tanggal_tanam,
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'message' => 'Penanaman berhasil diupdate',
            'data' => $data
        ]);
    }


    // ===============================
    // DELETE penanaman
    // ===============================
    public function destroy($id)
    {
        $user = auth('api')->user();

        $data = Penanaman::with('lahan')->findOrFail($id);

        if ($user->role == 'petani' && $data->lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $data->delete();

        return response()->json([
            'message' => 'Penanaman berhasil dihapus'
        ]);
    }
}