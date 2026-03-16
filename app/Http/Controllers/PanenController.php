<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use Illuminate\Http\Request;

class PanenController extends Controller
{
    public function index()
    {
        return Panen::with('penanaman')->get();
    }

    public function store(Request $request)
    {
        $data = Panen::create($request->all());

        return response()->json($data,201);
    }

    public function show($id)
    {
        return Panen::with('penanaman')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $panen = Panen::findOrFail($id);
        $panen->update($request->all());

        return $panen;
    }

    public function destroy($id)
    {
        Panen::destroy($id);

        return response()->json([
            'message'=>'Data panen dihapus'
        ]);
    }
}