<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\Sptjm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SptjmController extends Controller
{
    public function index(): View
    {
        $sptjms = Sptjm::with('penandatangan')->latest()->paginate(10);

        return view('sptjms.index', compact('sptjms'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('sptjms.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'isi_surat' => 'nullable|string',
            'penutup_surat' => 'nullable|string',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'pegawai' => 'nullable|array',
            'pegawai.*' => 'exists:asns,id',
        ]);

        $pegawai = $validated['pegawai'] ?? [];
        unset($validated['pegawai']);

        $sptjm = Sptjm::create($validated);
        $sptjm->pegawai()->sync($pegawai);

        return redirect()->route('sptjms.print', $sptjm)
            ->with('success', 'SPTJM berhasil disimpan.');
    }

    public function print(Sptjm $sptjm): View
    {
        $sptjm->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('sptjms.print', compact('sptjm', 'kopSuratBase64'));
    }

    public function edit(Sptjm $sptjm): View
    {
        $asns = Asn::orderBy('nama')->get();
        $sptjm->load('pegawai');

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('sptjms.edit', compact('asns', 'sptjm', 'defaultPenandatanganId'));
    }

    public function update(Request $request, Sptjm $sptjm): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'isi_surat' => 'nullable|string',
            'penutup_surat' => 'nullable|string',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'pegawai' => 'nullable|array',
            'pegawai.*' => 'exists:asns,id',
        ]);

        $pegawai = $validated['pegawai'] ?? [];
        unset($validated['pegawai']);

        $sptjm->update($validated);
        $sptjm->pegawai()->sync($pegawai);

        return redirect()->route('sptjms.print', $sptjm)
            ->with('success', 'SPTJM berhasil diperbarui.');
    }

    public function destroy(Sptjm $sptjm): RedirectResponse
    {
        $sptjm->delete();

        return redirect()->route('sptjms.index')->with('success', 'SPTJM berhasil dihapus.');
    }

    public static function formatTanggal($date, string $format = '%d %B %Y'): string
    {
        return DrhSatyalancanaController::formatTanggal($date, $format);
    }
}
