<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LaporanNodin;
use App\Models\LogoSetting;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanNodinController extends Controller
{
    public function index(): View
    {
        $laporanNodins = LaporanNodin::with(['penandatangan'])
            ->latest()
            ->paginate(10);

        return view('laporan_nodins.index', compact('laporanNodins'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $logos = LogoSetting::orderBy('name')->get();

        return view('laporan_nodins.create', compact('asns', 'logos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $laporanNodin = LaporanNodin::create($validated);

        return redirect()->route('laporan-nodins.print', $laporanNodin)
            ->with('success', 'Laporan Nota Dinas berhasil disimpan.');
    }

    public function edit(LaporanNodin $laporanNodin): View
    {
        $asns = Asn::orderBy('nama')->get();
        $logos = LogoSetting::orderBy('name')->get();
        $laporanNodin->load('penandatangan');

        return view('laporan_nodins.edit', compact('asns', 'logos', 'laporanNodin'));
    }

    public function update(Request $request, LaporanNodin $laporanNodin): RedirectResponse
    {
        $validated = $this->validateData($request);

        $laporanNodin->update($validated);

        return redirect()->route('laporan-nodins.print', $laporanNodin)
            ->with('success', 'Laporan Nota Dinas berhasil diperbarui.');
    }

    public function destroy(LaporanNodin $laporanNodin): RedirectResponse
    {
        $laporanNodin->delete();

        return redirect()->route('laporan-nodins.index')
            ->with('success', 'Laporan Nota Dinas berhasil dihapus.');
    }

    public function print(LaporanNodin $laporanNodin): View
    {
        $laporanNodin->load('penandatangan');

        $kopSuratBase64 = null;
        $logoName = $laporanNodin->kop_surat ?: 'kop_smk';
        $logo = LogoSetting::where('name', $logoName)->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('laporan_nodins.print', compact('laporanNodin', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'kepada' => 'nullable|string|max:255',
            'dari' => 'nullable|string|max:255',
            'nomor' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'perihal' => 'nullable|string|max:255',
            'dasar_pelaksanaan' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'peserta1_nama' => 'nullable|string|max:255',
            'peserta1_nip' => 'nullable|string|max:255',
            'peserta1_jabatan' => 'nullable|string|max:255',
            'peserta2_nama' => 'nullable|string|max:255',
            'peserta2_nip' => 'nullable|string|max:255',
            'peserta2_jabatan' => 'nullable|string|max:255',
            'pelaksanaan_tanggal' => 'nullable|date',
            'pelaksanaan_jam' => 'nullable|string|max:255',
            'pelaksanaan_tempat' => 'nullable|string|max:255',
            'kesimpulan' => 'nullable|string',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'kop_surat' => 'nullable|string|max:255',
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

        $days = [
            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis',
            5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
        ];

        $out = $format;
        $out = str_replace('%d', str_pad($carbon->format('d'), 2, '0', STR_PAD_LEFT), $out);
        $out = str_replace('%m', $carbon->format('m'), $out);
        $out = str_replace('%Y', $carbon->format('Y'), $out);

        if (str_contains($format, '%B')) {
            $out = str_replace('%B', $months[(int) $carbon->format('n')], $out);
        }

        if (str_contains($format, '%A')) {
            $out = str_replace('%A', $days[(int) $carbon->format('N')], $out);
        }

        return $out;
    }
}
