<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        return response()->json(MataPelajaran::orderBy('nama')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:mata_pelajaran,nama'
        ]);

        $mapel = MataPelajaran::create($validated);

        return response()->json($mapel, 201);
    }

    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->delete();

        return response()->json(['message' => 'Mata pelajaran berhasil dihapus']);
    }
} 