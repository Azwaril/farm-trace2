<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;

class LahanController extends Controller
{

    // GET semua lahan
    public function index()
    {
        $lahan = Lahan::with('user')->get();

        return response()->json([
            'message' => 'Data lahan berhasil diambil',
            'data' => $lahan
        ]);
    }

    // POST tambah lahan
    public function store(Request $request)
    {
        $request->validate([
            'nama_lahan'=>'required',
            'lokasi'=>'required',
            'luas_lahan'=>'required|numeric'
        ]);

        $lahan = Lahan::create([
            'users_id'=>auth('api')->id(),
            'nama_lahan'=>$request->nama_lahan,
            'lokasi'=>$request->lokasi,
            'luas_lahan'=>$request->luas_lahan
        ]);

        return response()->json([
            'message'=>'Lahan berhasil dibuat',
            'data'=>$lahan
        ],201);
    }

    // GET detail lahan
    public function show($id)
    {
        $lahan = Lahan::findOrFail($id);
        return response()->json($lahan);
    }

    // PUT update lahan
    public function update(Request $request,$id)
    {
        $lahan = Lahan::findOrFail($id);

        $lahan->update($request->all());

        return response()->json($lahan);
    }

    // DELETE lahan
    public function destroy($id)
    {
        $lahan = Lahan::findOrFail($id);
        $lahan->delete();

        return response()->json([
            'message'=>'Lahan berhasil dihapus'
        ]);
    }
}