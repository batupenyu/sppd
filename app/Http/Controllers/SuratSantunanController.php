<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratSantunan;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratSantunanController extends Controller
{
    public function index(): View
    {
        $suratSantunans = SuratSantunan::with(['penandatangan', 'pegawai'])
            ->latest()
            ->paginate(10);

        return view('surat_santunans.index', compact('suratSantunans'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_santunans.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratSantunan = SuratSantunan::create($validated);

        return redirect()->route('surat-santunans.print', $suratSantunan)
            ->with('success', 'Surat Santunan berhasil disimpan.');
    }

    public function edit(SuratSantunan $suratSantunan): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratSantunan->load('penandatangan', 'pegawai');

        return view('surat_santunans.edit', compact('asns', 'suratSantunan'));
    }

    public function update(Request $request, SuratSantunan $suratSantunan): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratSantunan->update($validated);

        return redirect()->route('surat-santunans.print', $suratSantunan)
            ->with('success', 'Surat Santunan berhasil diperbarui.');
    }

    public function destroy(SuratSantunan $suratSantunan): RedirectResponse
    {
        $suratSantunan->delete();

        return redirect()->route('surat-santunans.index')
            ->with('success', 'Surat Santunan berhasil dihapus.');
    }

    public function print(SuratSantunan $suratSantunan): View
    {
        $suratSantunan->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_santunans.print', compact('suratSantunan', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'instansi_tujuan_surat' => 'nullable|string|max:255',
            'kota_tujuan_surat' => 'nullable|string|max:255',
            'isi_surat_pertama' => 'nullable|string',
            'pegawai_id' => 'nullable|exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);
    }

    public static function formatTanggal($date, string $format = '%d %B %Y'): string
    {
        if (empty($date)) {
            return '-';
        }

        $carbon = $date instanceof CarbonInterface
            ? $date
            : Carbon::parse($date);

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $out = $format;
        $out = str_replace('%d', str_pad($carbon->format('d'), 2, '0', STR_PAD_LEFT), $out);
        $out = str_replace('%m', $carbon->format('m'), $out);
        $out = str_replace('%Y', $carbon->format('Y'), $out);

        if (str_contains($format, '%B')) {
            $out = str_replace('%B', $months[(int) $carbon->format('n')], $out);
        }

        return $out;
    }
}
