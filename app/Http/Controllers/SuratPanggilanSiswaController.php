<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\LogoSetting;
use App\Models\SuratPanggilanSiswa;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratPanggilanSiswaController extends Controller
{
    public function index(): View
    {
        $suratPanggilanSiswas = SuratPanggilanSiswa::with(['siswa', 'waliKelas', 'guruBk', 'wakasekKesiswaan'])
            ->latest()
            ->paginate(10);

        return view('surat_panggilan_siswas.index', compact('suratPanggilanSiswas'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();

        return view('surat_panggilan_siswas.create', compact('asns', 'siswas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);
        $validated['guru_bk_an'] = $request->has('guru_bk_an');

        $suratPanggilanSiswa = SuratPanggilanSiswa::create($validated);

        return redirect()->route('surat-panggilan-siswas.print', $suratPanggilanSiswa)
            ->with('success', 'Surat Panggilan Siswa berhasil disimpan.');
    }

    public function edit(SuratPanggilanSiswa $suratPanggilanSiswa): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $suratPanggilanSiswa->load('siswa', 'waliKelas', 'guruBk', 'wakasekKesiswaan');

        return view('surat_panggilan_siswas.edit', compact('asns', 'siswas', 'suratPanggilanSiswa'));
    }

    public function update(Request $request, SuratPanggilanSiswa $suratPanggilanSiswa): RedirectResponse
    {
        $validated = $this->validateData($request);
        $validated['guru_bk_an'] = $request->has('guru_bk_an');

        $suratPanggilanSiswa->update($validated);

        return redirect()->route('surat-panggilan-siswas.print', $suratPanggilanSiswa)
            ->with('success', 'Surat Panggilan Siswa berhasil diperbarui.');
    }

    public function destroy(SuratPanggilanSiswa $suratPanggilanSiswa): RedirectResponse
    {
        $suratPanggilanSiswa->delete();

        return redirect()->route('surat-panggilan-siswas.index')
            ->with('success', 'Surat Panggilan Siswa berhasil dihapus.');
    }

    public function print(SuratPanggilanSiswa $suratPanggilanSiswa): View
    {
        $suratPanggilanSiswa->load('siswa', 'waliKelas', 'guruBk', 'wakasekKesiswaan');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_panggilan_siswas.print', compact('suratPanggilanSiswa', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'siswa_id' => 'nullable|exists:data_siswa,id',
            'keterangan_panggilan' => 'nullable|string|max:255',
            'tanggal_panggilan' => 'nullable|date',
            'waktu_panggilan' => 'nullable|string|max:255',
            'tempat_panggilan' => 'nullable|string|max:255',
            'wali_kelas_id' => 'nullable|exists:asns,id',
            'guru_bk_id' => 'nullable|exists:asns,id',
            'guru_bk_an' => 'nullable|boolean',
            'wakasek_kesiswaan_id' => 'nullable|exists:asns,id',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
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
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $out = $format;
        $out = str_replace('%d', str_pad($carbon->format('d'), 2, '0', STR_PAD_LEFT), $out);
        $out = str_replace('%m', $carbon->format('m'), $out);
        $out = str_replace('%Y', $carbon->format('Y'), $out);

        if (str_contains($format, '%B')) {
            $out = str_replace('%B', $months[(int) $carbon->format('n')], $out);
        }

        if (str_contains($format, '%A')) {
            $out = str_replace('%A', $days[$carbon->format('l')] ?? $carbon->format('l'), $out);
        }

        return $out;
    }
}
