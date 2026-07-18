<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratKp4;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratKp4Controller extends Controller
{
    public function index(): View
    {
        $suratKp4s = SuratKp4::with(['pegawai', 'penandatangan'])
            ->latest()
            ->paginate(10);

        return view('surat_kp4s.index', compact('suratKp4s'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_kp4s.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratKp4 = SuratKp4::create($validated);

        $this->syncAnggotaKeluarga($suratKp4, $request);

        return redirect()->route('surat-kp4s.print', $suratKp4)
            ->with('success', 'Surat KP4 berhasil disimpan.');
    }

    public function edit(SuratKp4 $suratKp4): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratKp4->load('pegawai', 'penandatangan', 'anggotaKeluarga');

        return view('surat_kp4s.edit', compact('asns', 'suratKp4'));
    }

    public function update(Request $request, SuratKp4 $suratKp4): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratKp4->update($validated);

        $this->syncAnggotaKeluarga($suratKp4, $request);

        return redirect()->route('surat-kp4s.print', $suratKp4)
            ->with('success', 'Surat KP4 berhasil diperbarui.');
    }

    public function destroy(SuratKp4 $suratKp4): RedirectResponse
    {
        $suratKp4->delete();

        return redirect()->route('surat-kp4s.index')
            ->with('success', 'Surat KP4 berhasil dihapus.');
    }

    public function print(SuratKp4 $suratKp4): View
    {
        $suratKp4->load('pegawai', 'penandatangan', 'anggotaKeluarga');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_kp4s.print', compact('suratKp4', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'status_kepegawaian' => 'nullable|string|max:255',
            'masa_kerja_golongan' => 'nullable|string|max:255',
            'digaji_menurut' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);
    }

    private function syncAnggotaKeluarga(SuratKp4 $suratKp4, Request $request): void
    {
        $suratKp4->anggotaKeluarga()->delete();

        $anggota = $request->input('anggota', []);
        if (! is_array($anggota)) {
            return;
        }

        foreach ($anggota as $item) {
            if (empty($item['nama'])) {
                continue;
            }

            $suratKp4->anggotaKeluarga()->create([
                'nama' => $item['nama'],
                'nama_suami_istri' => $item['nama_suami_istri'] ?? null,
                'tanggal_kelahiran' => $item['tanggal_kelahiran'] ?? null,
                'tanggal_perkawinan' => $item['tanggal_perkawinan'] ?? null,
                'pekerjaan' => $item['pekerjaan'] ?? null,
                'keterangan' => $item['keterangan'] ?? null,
                'mendapat_tunjangan' => isset($item['mendapat_tunjangan']),
            ]);
        }
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
