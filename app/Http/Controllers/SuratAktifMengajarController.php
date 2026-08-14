<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratAktifMengajar;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratAktifMengajarController extends Controller
{
    public function index(): View
    {
        $suratAktifMengajars = SuratAktifMengajar::with(['penandatangan', 'pegawai'])
            ->latest()
            ->paginate(10);

        return view('surat_aktif_mengajars.index', compact('suratAktifMengajars'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_aktif_mengajars.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratAktifMengajar = SuratAktifMengajar::create($validated);

        return redirect()->route('surat-aktif-mengajars.print', $suratAktifMengajar)
            ->with('success', 'Surat Aktif Mengajar berhasil disimpan.');
    }

    public function edit(SuratAktifMengajar $suratAktifMengajar): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratAktifMengajar->load('penandatangan', 'pegawai');

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_aktif_mengajars.edit', compact('asns', 'suratAktifMengajar', 'defaultPenandatanganId'));
    }

    public function update(Request $request, SuratAktifMengajar $suratAktifMengajar): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratAktifMengajar->update($validated);

        return redirect()->route('surat-aktif-mengajars.print', $suratAktifMengajar)
            ->with('success', 'Surat Aktif Mengajar berhasil diperbarui.');
    }

    public function destroy(SuratAktifMengajar $suratAktifMengajar): RedirectResponse
    {
        $suratAktifMengajar->delete();

        return redirect()->route('surat-aktif-mengajars.index')
            ->with('success', 'Surat Aktif Mengajar berhasil dihapus.');
    }

    public function print(SuratAktifMengajar $suratAktifMengajar): View
    {
        $suratAktifMengajar->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_aktif_mengajars.print', compact('suratAktifMengajar', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'pegawai_id' => 'required|exists:asns,id',
            'penandatangan_id' => 'required|exists:asns,id',
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

        return $out;
    }
}
