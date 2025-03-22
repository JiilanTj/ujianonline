<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        return response()->json($kelas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tingkat' => 'required|string|in:VII,VIII,IX,X,XI,XII',
            'nama_kelas' => 'required|string|max:255|unique:kelas',
            'jurusan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kelas = Kelas::create($validator->validated());
            return response()->json([
                'message' => 'Kelas berhasil ditambahkan',
                'data' => $kelas
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Kelas $kelas)
    {
        try {
            $kelas->delete();
            return response()->json([
                'message' => 'Kelas berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus kelas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 