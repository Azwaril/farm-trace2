<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPupuk;
use Illuminate\Http\Request;

class RiwayatPupukController extends Controller
{
    public function index()
    {
        return RiwayatPupuk::with(['penanaman','pupuk'])->get();
    }

    public function store(Request $request)
    {
        $data = RiwayatPupuk::create($request->all());

        return response()->json($data,201);
    }

    public function show($id)
    {
        return RiwayatPupuk::with(['penanaman','pupuk'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = RiwayatPupuk::findOrFail($id);
        $data->update($request->all());

        return $data;
    }

    public function destroy($id)
    {
        RiwayatPupuk::destroy($id);

        return response()->json([
            'message'=>'Data riwayat pupuk dihapus'
        ]);
    }
}