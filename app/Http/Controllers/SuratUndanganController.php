<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\LogoSetting;
use App\Models\SuratUndangan;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratUndanganController extends Controller
{
    public function index(): View
    {
        $suratUndangans = SuratUndangan::with(['kepalaSekolah', 'siswa'])
            ->latest()
            ->paginate(10);

        return view('surat_undangans.index', compact('suratUndangans'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();

        return view('surat_undangans.create', compact('asns', 'siswas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratUndangan = SuratUndangan::create($validated);

        return redirect()->route('surat-undangans.print', $suratUndangan)
            ->with('success', 'Surat Undangan berhasil disimpan.');
    }

    public function edit(SuratUndangan $suratUndangan): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $suratUndangan->load('kepalaSekolah', 'siswa');

        return view('surat_undangans.edit', compact('asns', 'siswas', 'suratUndangan'));
    }

    public function update(Request $request, SuratUndangan $suratUndangan): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratUndangan->update($validated);

        return redirect()->route('surat-undangans.print', $suratUndangan)
            ->with('success', 'Surat Undangan berhasil diperbarui.');
    }

    public function destroy(SuratUndangan $suratUndangan): RedirectResponse
    {
        $suratUndangan->delete();

        return redirect()->route('surat-undangans.index')
            ->with('success', 'Surat Undangan berhasil dihapus.');
    }

    public function print(SuratUndangan $suratUndangan): View
    {
        $suratUndangan->load('kepalaSekolah', 'siswa');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_undangans.print', compact('suratUndangan', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'kepada_yth' => 'nullable|string|max:255',
            'siswa_id' => 'nullable|exists:data_siswa,id',
            'tanggal' => 'nullable|date',
            'waktu' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'acara' => 'nullable|string',
            'pembuka_surat' => 'nullable|string',
            'penutup_surat' => 'nullable|string',
            'kepala_sekolah_id' => 'nullable|exists:asns,id',
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

        $out = $format;
        $out = str_replace('%d', str_pad($carbon->format('d'), 2, '0', STR_PAD_LEFT), $out);
        $out = str_replace('%m', $carbon->format('m'), $out);
        $out = str_replace('%Y', $carbon->format('Y'), $out);

        if (str_contains($format, '%B')) {
            $out = str_replace('%B', $months[(int) $carbon->format('n')], $out);
        }

        if (str_contains($format, '%A')) {
            $days = [
                1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis',
                5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
            ];
            $out = str_replace('%A', $days[(int) $carbon->format('N')], $out);
        }

        return $out;
    }
}
