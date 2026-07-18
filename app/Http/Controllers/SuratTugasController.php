<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratTugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratTugasController extends Controller
{
    public function index(): View
    {
        $suratTugas = SuratTugas::latest()->paginate(10);

        return view('surat_tugas.index', compact('suratTugas'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_tugas.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor' => 'nullable|string|max:100',
            'dasar' => 'nullable|string',
            'peserta' => 'nullable|array',
            'peserta.*' => 'exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'untuk_1' => 'nullable|string',
            'untuk_2' => 'nullable|string',
            'untuk_3' => 'nullable|string',
            'dikeluarkan_di' => 'nullable|string|max:255',
            'tanggal_dikeluarkan' => 'nullable|date',
            'jabatan_penandatangan' => 'nullable|string|max:255',
            'nama_penandatangan' => 'nullable|string|max:255',
            'nip_penandatangan' => 'nullable|string|max:255',
        ]);

        SuratTugas::create($validated);

        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil dibuat.');
    }

    public function edit(SuratTugas $suratTugas): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_tugas.edit', compact('suratTugas', 'asns'));
    }

    public function update(Request $request, SuratTugas $suratTugas): RedirectResponse
    {
        $validated = $request->validate([
            'nomor' => 'nullable|string|max:100',
            'dasar' => 'nullable|string',
            'peserta' => 'nullable|array',
            'peserta.*' => 'exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'untuk_1' => 'nullable|string',
            'untuk_2' => 'nullable|string',
            'untuk_3' => 'nullable|string',
            'dikeluarkan_di' => 'nullable|string|max:255',
            'tanggal_dikeluarkan' => 'nullable|date',
            'jabatan_penandatangan' => 'nullable|string|max:255',
            'nama_penandatangan' => 'nullable|string|max:255',
            'nip_penandatangan' => 'nullable|string|max:255',
        ]);

        $suratTugas->update($validated);

        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil diperbarui.');
    }

    public function destroy(SuratTugas $suratTugas): RedirectResponse
    {
        $suratTugas->delete();

        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil dihapus.');
    }

    public function print(SuratTugas $suratTugas): View
    {
        $peserta = $suratTugas->getPeserta();

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_tugas.print', compact('suratTugas', 'peserta', 'kopSuratBase64'));
    }
}
