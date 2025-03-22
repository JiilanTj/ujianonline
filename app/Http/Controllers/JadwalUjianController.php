<?php

namespace App\Http\Controllers;

use App\Models\JadwalUjian;
use App\Models\BankSoal;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalUjianController extends Controller
{
    public function index()
    {
        $jadwalUjian = JadwalUjian::with(['bankSoal', 'kelas'])
            ->latest()
            ->paginate(10);

        return view('jadwal-ujian.index', compact('jadwalUjian'));
    }

    public function create()
    {
        $bankSoal = BankSoal::all();
        $kelas = Kelas::all();
        return view('jadwal-ujian.create', compact('bankSoal', 'kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'bank_soal_id' => 'required|exists:bank_soal,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'instruksi' => 'nullable|string',
            'kelas_ids' => 'required|array',
            'kelas_ids.*' => 'exists:kelas,id'
        ]);

        $validated['created_by'] = auth()->id();
        $jadwalUjian = JadwalUjian::create($validated);
        
        // Attach selected kelas
        $jadwalUjian->kelas()->attach($request->kelas_ids);

        return redirect()
            ->route('jadwal-ujian.index')
            ->with('success', 'Jadwal ujian berhasil dibuat!');
    }

    public function edit(JadwalUjian $jadwalUjian)
    {
        $bankSoal = BankSoal::all();
        $kelas = Kelas::all();
        return view('jadwal-ujian.edit', compact('jadwalUjian', 'bankSoal', 'kelas'));
    }

    public function update(Request $request, JadwalUjian $jadwalUjian)
    {
        $validated = $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'bank_soal_id' => 'required|exists:bank_soal,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'instruksi' => 'nullable|string',
            'kelas_ids' => 'required|array',
            'kelas_ids.*' => 'exists:kelas,id'
        ]);

        $jadwalUjian->update($validated);
        
        // Sync selected kelas
        $jadwalUjian->kelas()->sync($request->kelas_ids);

        return redirect()
            ->route('jadwal-ujian.index')
            ->with('success', 'Jadwal ujian berhasil diperbarui!');
    }

    public function destroy(JadwalUjian $jadwalUjian)
    {
        $jadwalUjian->delete();
        return redirect()
            ->route('jadwal-ujian.index')
            ->with('success', 'Jadwal ujian berhasil dihapus!');
    }
}