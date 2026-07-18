<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratResmi;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratResmiController extends Controller
{
    public function index(): View
    {
        $suratResmis = SuratResmi::with(['penandatangan', 'pegawai'])
            ->latest()
            ->paginate(10);

        return view('surat_resmis.index', compact('suratResmis'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_resmis.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $pegawaiIds = $validated['pegawai_ids'] ?? [];
        unset($validated['pegawai_ids']);

        $suratResmi = SuratResmi::create($validated);
        $suratResmi->pegawai()->sync($pegawaiIds);

        return redirect()->route('surat-resmis.print', $suratResmi)
            ->with('success', 'Surat Resmi berhasil disimpan.');
    }

    public function edit(SuratResmi $suratResmi): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratResmi->load('penandatangan', 'pegawai');

        return view('surat_resmis.edit', compact('asns', 'suratResmi'));
    }

    public function update(Request $request, SuratResmi $suratResmi): RedirectResponse
    {
        $validated = $this->validateData($request);

        $pegawaiIds = $validated['pegawai_ids'] ?? [];
        unset($validated['pegawai_ids']);

        $suratResmi->update($validated);
        $suratResmi->pegawai()->sync($pegawaiIds);

        return redirect()->route('surat-resmis.print', $suratResmi)
            ->with('success', 'Surat Resmi berhasil diperbarui.');
    }

    public function destroy(SuratResmi $suratResmi): RedirectResponse
    {
        $suratResmi->delete();

        return redirect()->route('surat-resmis.index')
            ->with('success', 'Surat Resmi berhasil dihapus.');
    }

    public function print(SuratResmi $suratResmi): View
    {
        $suratResmi->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_resmis.print', compact('suratResmi', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor' => 'nullable|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'pejabat_tujuan_surat' => 'nullable|string|max:255',
            'kota_tujuan_surat' => 'nullable|string|max:255',
            'pembuka_surat' => 'nullable|string',
            'isi_surat' => 'nullable|string',
            'penutup_surat' => 'nullable|string',
            'tanggal_kegiatan' => 'nullable|date',
            'waktu_kegiatan' => 'nullable|string|max:255',
            'tempat_kegiatan' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'pegawai_ids' => 'nullable|array',
            'pegawai_ids.*' => 'nullable|exists:asns,id',
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
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
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
