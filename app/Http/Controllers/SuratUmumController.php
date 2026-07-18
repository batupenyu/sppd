<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratUmum;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratUmumController extends Controller
{
    public function index(): View
    {
        $suratUmums = SuratUmum::with(['penandatangan', 'pegawai'])
            ->latest()
            ->paginate(10);

        return view('surat_umums.index', compact('suratUmums'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_umums.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratUmum = SuratUmum::create($validated);

        return redirect()->route('surat-umums.print', $suratUmum)
            ->with('success', 'Surat Umum berhasil disimpan.');
    }

    public function edit(SuratUmum $suratUmum): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratUmum->load('penandatangan', 'pegawai');

        return view('surat_umums.edit', compact('asns', 'suratUmum'));
    }

    public function update(Request $request, SuratUmum $suratUmum): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratUmum->update($validated);

        return redirect()->route('surat-umums.print', $suratUmum)
            ->with('success', 'Surat Umum berhasil diperbarui.');
    }

    public function destroy(SuratUmum $suratUmum): RedirectResponse
    {
        $suratUmum->delete();

        return redirect()->route('surat-umums.index')
            ->with('success', 'Surat Umum berhasil dihapus.');
    }

    public function print(SuratUmum $suratUmum): View
    {
        $suratUmum->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_umums.print', compact('suratUmum', 'kopSuratBase64'));
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
