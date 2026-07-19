<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\Spmt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpmtController extends Controller
{
    public function index(): View
    {
        $spmts = Spmt::with(['penandatangan', 'pegawai'])->latest()->paginate(10);

        return view('spmts.index', compact('spmts'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('spmts.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'pegawai_id' => 'nullable|exists:asns,id',
            'peraturan' => 'nullable|string|max:255',
            'nomor_peraturan' => 'nullable|string|max:255',
            'tahun_peraturan' => 'nullable|string|max:10',
            'tentang' => 'nullable|string',
            'tanggal_terhitung' => 'nullable|date',
            'sebagai' => 'nullable|string|max:255',
            'tempat_tugas' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
        ]);

        $spmt = Spmt::create($validated);

        return redirect()->route('spmts.print', $spmt)
            ->with('success', 'SPMT berhasil disimpan.');
    }

    public function edit(Spmt $spmt): View
    {
        $asns = Asn::orderBy('nama')->get();
        $spmt->load('penandatangan', 'pegawai');

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('spmts.edit', compact('asns', 'spmt', 'defaultPenandatanganId'));
    }

    public function update(Request $request, Spmt $spmt): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'pegawai_id' => 'nullable|exists:asns,id',
            'peraturan' => 'nullable|string|max:255',
            'nomor_peraturan' => 'nullable|string|max:255',
            'tahun_peraturan' => 'nullable|string|max:10',
            'tentang' => 'nullable|string',
            'tanggal_terhitung' => 'nullable|date',
            'sebagai' => 'nullable|string|max:255',
            'tempat_tugas' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
        ]);

        $spmt->update($validated);

        return redirect()->route('spmts.print', $spmt)
            ->with('success', 'SPMT berhasil diperbarui.');
    }

    public function destroy(Spmt $spmt): RedirectResponse
    {
        $spmt->delete();

        return redirect()->route('spmts.index')->with('success', 'SPMT berhasil dihapus.');
    }

    public function print(Spmt $spmt): View
    {
        $spmt->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('spmts.print', compact('spmt', 'kopSuratBase64'));
    }

    public static function formatTanggal($date, string $format = '%d %B %Y'): string
    {
        return DrhSatyalancanaController::formatTanggal($date, $format);
    }
}
