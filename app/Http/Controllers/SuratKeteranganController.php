<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\LogoSetting;
use App\Models\SuratKeterangan;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratKeteranganController extends Controller
{
    public function index(): View
    {
        $suratKeterangans = SuratKeterangan::with(['penandatangan', 'pegawai', 'siswa'])
            ->latest()
            ->paginate(10);

        return view('surat_keterangans.index', compact('suratKeterangans'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();

        return view('surat_keterangans.create', compact('asns', 'siswas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratKeterangan = SuratKeterangan::create($validated);

        return redirect()->route('surat-keterangans.print', $suratKeterangan)
            ->with('success', 'Surat Keterangan berhasil disimpan.');
    }

    public function edit(SuratKeterangan $suratKeterangan): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $suratKeterangan->load('penandatangan', 'pegawai', 'siswa');

        return view('surat_keterangans.edit', compact('asns', 'siswas', 'suratKeterangan'));
    }

    public function update(Request $request, SuratKeterangan $suratKeterangan): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratKeterangan->update($validated);

        return redirect()->route('surat-keterangans.print', $suratKeterangan)
            ->with('success', 'Surat Keterangan berhasil diperbarui.');
    }

    public function destroy(SuratKeterangan $suratKeterangan): RedirectResponse
    {
        $suratKeterangan->delete();

        return redirect()->route('surat-keterangans.index')
            ->with('success', 'Surat Keterangan berhasil dihapus.');
    }

    public function print(SuratKeterangan $suratKeterangan): View
    {
        $suratKeterangan->load('penandatangan', 'pegawai', 'siswa');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_keterangans.print', compact('suratKeterangan', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'isi_surat' => 'nullable|string',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'siswa_id' => 'nullable|exists:data_siswa,id',
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
