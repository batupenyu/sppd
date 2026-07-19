<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratPernyataan;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratPernyataanController extends Controller
{
    public function index(): View
    {
        $suratPernyataans = SuratPernyataan::with(['penandatangan', 'pegawai'])
            ->latest()
            ->paginate(10);

        return view('surat_pernyataans.index', compact('suratPernyataans'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_pernyataans.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratPernyataan = SuratPernyataan::create($validated);

        return redirect()->route('surat-pernyataans.print', $suratPernyataan)
            ->with('success', 'Surat Pernyataan berhasil disimpan.');
    }

    public function edit(SuratPernyataan $suratPernyataan): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratPernyataan->load('penandatangan', 'pegawai');

        return view('surat_pernyataans.edit', compact('asns', 'suratPernyataan'));
    }

    public function update(Request $request, SuratPernyataan $suratPernyataan): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratPernyataan->update($validated);

        return redirect()->route('surat-pernyataans.print', $suratPernyataan)
            ->with('success', 'Surat Pernyataan berhasil diperbarui.');
    }

    public function destroy(SuratPernyataan $suratPernyataan): RedirectResponse
    {
        $suratPernyataan->delete();

        return redirect()->route('surat-pernyataans.index')
            ->with('success', 'Surat Pernyataan berhasil dihapus.');
    }

    public function print(SuratPernyataan $suratPernyataan): View
    {
        $suratPernyataan->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_pernyataans.print', compact('suratPernyataan', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'pembuka_surat' => 'nullable|string',
            'isi_surat' => 'nullable|string',
            'penutup_surat' => 'nullable|string',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
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
