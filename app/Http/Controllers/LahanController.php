<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;

class LahanController extends Controller
{

    public function index()
    {
        $user = auth('api')->user();

        if ($user->role == 'admin') {
            $lahan = Lahan::with('user')->get();
        } else if ($user->role == 'petani') {
            $lahan = Lahan::where('users_id', $user->id)->get();
        } else {
            return response()->json([
                'message' => 'Konsumen tidak dapat melihat lahan'
            ],403);
        }

        return response()->json($lahan);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lahan' => 'required',
            'lokasi' => 'required',
            'luas_lahan' => 'required|numeric'
        ]);

        $lahan = Lahan::create([
            'users_id' => auth('api')->id(),
            'nama_lahan' => $request->nama_lahan,
            'lokasi' => $request->lokasi,
            'luas_lahan' => $request->luas_lahan
        ]);

        return response()->json([
            'message' => 'Lahan berhasil ditambahkan',
            'data' => $lahan
        ],201);
    }

    public function show($id)
    {
        $user = auth('api')->user();
        $lahan = Lahan::findOrFail($id);

        if ($user->role == 'petani' && $lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        return response()->json($lahan);
    }

    public function update(Request $request,$id)
    {
        $lahan = Lahan::findOrFail($id);
        $user = auth('api')->user();

        if ($user->role == 'petani' && $lahan->users_id != $user->id) {
            return response()->json([
                'message' => 'Akses ditolak'
            ],403);
        }

        $lahan->update($request->all());

        return response()->json([
            'message'=>'Lahan berhasil diupdate',
            'data'=>$lahan
        ]);
    }

    public function destroy($id)
    {
        $lahan = Lahan::findOrFail($id);
        $user = auth('api')->user();

        if ($user->role == 'petani' && $lahan->users_id != $user->id) {
            return response()->json([
                'message'=>'Akses ditolak'
            ],403);
        }

        $lahan->delete();

        return response()->json([
            'message'=>'Lahan berhasil dihapus'
        ]);
    }
}