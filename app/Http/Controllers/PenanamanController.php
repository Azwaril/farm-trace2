<?php

namespace App\Http\Controllers;

use App\Models\Penanaman;
use Illuminate\Http\Request;

class PenanamanController extends Controller
{

    // GET semua tanaman
    public function index()
    {
        $data = Penanaman::with(['lahan','tanaman','varietas'])->get();

        return response()->json([
            'message' => 'Data tanaman berhasil diambil',
            'data' => $data
        ]);
    }

    // POST tambah tanaman
    public function store(Request $request)
    {
        $request->validate([
            'tanaman_id'=>'required|exists:tanaman,id',
            'lahan_id'=>'required|exists:lahan,id',
            'varietas_id'=>'required|exists:varietas,id',
            'tanggal_tanam'=>'required|date'
        ]);

        $data = Penanaman::create([
            'tanaman_id'=>$request->tanaman_id,
            'lahan_id'=>$request->lahan_id,
            'varietas_id'=>$request->varietas_id,
            'tanggal_tanam'=>$request->tanggal_tanam,
            'catatan'=>$request->catatan
        ]);

        return response()->json([
            'message'=>'Tanaman berhasil ditambahkan',
            'data'=>$data
        ],201);
    }

    // GET detail tanaman
    public function show($id)
    {
        $data = Penanaman::with(['lahan','tanaman','varietas'])->findOrFail($id);

        return response()->json($data);
    }

    // UPDATE tanaman
    public function update(Request $request,$id)
    {
        $data = Penanaman::findOrFail($id);

        $data->update($request->all());

        return response()->json([
            'message'=>'Tanaman berhasil diupdate',
            'data'=>$data
        ]);
    }

    // DELETE tanaman
    public function destroy($id)
    {
        $data = Penanaman::findOrFail($id);
        $data->delete();

        return response()->json([
            'message'=>'Tanaman berhasil dihapus'
        ]);
    }
}