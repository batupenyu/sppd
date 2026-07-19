<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratRekomendasi;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratRekomendasiController extends Controller
{
    public function index(): View
    {
        $suratRekomendasis = SuratRekomendasi::with(['penandatangan', 'pegawai'])
            ->latest()
            ->paginate(10);

        return view('surat_rekomendasis.index', compact('suratRekomendasis'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_rekomendasis.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratRekomendasi = SuratRekomendasi::create($validated);

        return redirect()->route('surat-rekomendasis.print', $suratRekomendasi)
            ->with('success', 'Surat Rekomendasi Studi Lanjut berhasil disimpan.');
    }

    public function edit(SuratRekomendasi $suratRekomendasi): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratRekomendasi->load('penandatangan', 'pegawai');

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_rekomendasis.edit', compact('asns', 'suratRekomendasi', 'defaultPenandatanganId'));
    }

    public function update(Request $request, SuratRekomendasi $suratRekomendasi): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratRekomendasi->update($validated);

        return redirect()->route('surat-rekomendasis.print', $suratRekomendasi)
            ->with('success', 'Surat Rekomendasi Studi Lanjut berhasil diperbarui.');
    }

    public function destroy(SuratRekomendasi $suratRekomendasi): RedirectResponse
    {
        $suratRekomendasi->delete();

        return redirect()->route('surat-rekomendasis.index')
            ->with('success', 'Surat Rekomendasi Studi Lanjut berhasil dihapus.');
    }

    public function print(SuratRekomendasi $suratRekomendasi): View
    {
        $suratRekomendasi->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_rekomendasis.print', compact('suratRekomendasi', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'nama_universitas' => 'nullable|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'pertimbangan' => 'nullable|string',
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
