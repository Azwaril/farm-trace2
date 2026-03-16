<?php

namespace App\Http\Controllers;

use App\Models\Pupuk;
use Illuminate\Http\Request;

class PupukController extends Controller
{

    public function index()
    {
        $data = Pupuk::all();

        return response()->json([
            'message' => 'Data pupuk berhasil diambil',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pupuk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $url = null;

        if ($request->hasFile('image')) {

            $result = $request->file('image')->storeOnCloudinary('farm-trace/pupuk');

            $url = $result->getSecurePath();
        }

        $pupuk = Pupuk::create([
            'nama_pupuk' => $request->nama_pupuk,
            'deskripsi' => $request->deskripsi,
            'image' => $url
        ]);

        return response()->json([
            'message' => 'Pupuk berhasil ditambahkan',
            'data' => $pupuk
        ], 201);
    }

    public function show($id)
    {
        $pupuk = Pupuk::findOrFail($id);

        return response()->json([
            'message' => 'Detail pupuk',
            'data' => $pupuk
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $pupuk = Pupuk::findOrFail($id);

        $url = $pupuk->image;

        if ($request->hasFile('image')) {

            $result = $request->file('image')->storeOnCloudinary('farm-trace/pupuk');

            $url = $result->getSecurePath();
        }

        $pupuk->update([
            'nama_pupuk' => $request->nama_pupuk ?? $pupuk->nama_pupuk,
            'deskripsi' => $request->deskripsi ?? $pupuk->deskripsi,
            'image' => $url
        ]);

        return response()->json([
            'message' => 'Pupuk berhasil diperbarui',
            'data' => $pupuk
        ], 200);
    }

    public function destroy($id)
    {
        $pupuk = Pupuk::findOrFail($id);

        $pupuk->delete();

        return response()->json([
            'message' => 'Data pupuk berhasil dihapus'
        ], 200);
    }
}