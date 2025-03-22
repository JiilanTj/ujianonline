<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        $query = BankSoal::query()
            ->with(['mataPelajaran', 'creator']);

        // Apply type filter if selected
        if ($request->filled('tipe')) {
            $tipe = $request->tipe;
            if ($tipe === 'kombinasi') {
                // For kombinasi, we'll check if the bank soal has both types of questions
                $query->whereHas('soal', function ($q) {
                    $q->where('tipe', 'pilihan_ganda');
                })->whereHas('soal', function ($q) {
                    $q->where('tipe', 'essay');
                });
            } else {
                // For single type (pilihan_ganda or essay)
                $query->where('tipe', $tipe);
            }
        }

        $bankSoal = $query->latest()->paginate(10);

        return view('bank-soal.index', compact('bankSoal'));
    }

    public function create()
    {
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        return view('bank-soal.create', compact('mataPelajaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank_soal' => 'required|string|max:255',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tipe' => 'required|in:pilihan_ganda,essay,kombinasi',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        $bankSoal = BankSoal::create($validated);

        // Redirect ke halaman tambah soal dengan flash message
        return redirect()->route('bank-soal.edit', $bankSoal)
            ->with('success', 'Bank Soal berhasil dibuat! Silakan tambahkan soal-soal.');
    }

    public function edit(BankSoal $bankSoal)
    {
        return view('bank-soal.edit', compact('bankSoal'));
    }

    // Menambah soal ke bank soal
    public function storeSoal(Request $request, BankSoal $bankSoal)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:pilihan_ganda,essay',
            'pilihan_a' => 'required_if:tipe,pilihan_ganda',
            'pilihan_b' => 'required_if:tipe,pilihan_ganda',
            'pilihan_c' => 'nullable',
            'pilihan_d' => 'nullable',
            'pilihan_e' => 'nullable',
            'jawaban_benar' => 'required_if:tipe,pilihan_ganda',
            'kunci_jawaban' => 'required_if:tipe,essay',
            'pembahasan' => 'nullable|string',
            'tingkat_kesulitan' => 'required|in:1,2,3',
        ]);

        // Hitung urutan terakhir
        $lastOrder = $bankSoal->soal()->max('urutan') ?? 0;
        $validated['urutan'] = $lastOrder + 1;

        $soal = $bankSoal->soal()->create($validated);

        return response()->json([
            'message' => 'Soal berhasil ditambahkan',
            'soal' => $soal
        ]);
    }

    // Update soal
    public function updateSoal(Request $request, BankSoal $bankSoal, $soalId)
    {
        $soal = $bankSoal->soal()->findOrFail($soalId);
        
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:pilihan_ganda,essay',
            'pilihan_a' => 'required_if:tipe,pilihan_ganda',
            'pilihan_b' => 'required_if:tipe,pilihan_ganda',
            'pilihan_c' => 'nullable',
            'pilihan_d' => 'nullable',
            'pilihan_e' => 'nullable',
            'jawaban_benar' => 'required',
            'kunci_jawaban' => 'required_if:tipe,essay',
            'pembahasan' => 'nullable|string',
            'tingkat_kesulitan' => 'required|in:1,2,3',
            'urutan' => 'nullable|integer'
        ]);

        $soal->update($validated);

        return response()->json([
            'message' => 'Soal berhasil diperbarui',
            'soal' => $soal
        ]);
    }

    // Hapus soal
    public function destroySoal(BankSoal $bankSoal, $soalId)
    {
        $soal = $bankSoal->soal()->findOrFail($soalId);
        $soal->delete();

        return response()->json([
            'message' => 'Soal berhasil dihapus'
        ]);
    }

    public function update(Request $request, BankSoal $bankSoal)
    {
        $validated = $request->validate([
            'nama_bank_soal' => 'required|string|max:255',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tipe' => 'required|in:pilihan_ganda,essay,kombinasi',
            'deskripsi' => 'nullable|string',
        ]);

        $bankSoal->update($validated);

        return redirect()->route('bank-soal.index')
            ->with('success', 'Bank Soal berhasil diperbarui');
    }

    public function destroy(BankSoal $bankSoal)
    {
        $bankSoal->delete();
        return redirect()->route('bank-soal.index')
            ->with('success', 'Bank Soal berhasil dihapus');
    }

    public function getSoal(BankSoal $bankSoal)
    {
        $soal = $bankSoal->soal()->orderBy('urutan')->get();
        return response()->json($soal);
    }
} 