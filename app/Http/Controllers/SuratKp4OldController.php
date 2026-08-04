<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratKp4Old;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratKp4OldController extends Controller
{
    public function index(): View
    {
        $suratKp4Olds = SuratKp4Old::with(['pegawai', 'penandatangan'])
            ->latest()
            ->paginate(10);

        return view('surat_kp4_olds.index', compact('suratKp4Olds'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_kp4_olds.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratKp4Old = SuratKp4Old::create($validated);

        $this->syncAnggotaKeluarga($suratKp4Old, $request);
        $this->syncAnak($suratKp4Old, $request);

        return redirect()->route('surat-kp4-olds.print', $suratKp4Old)
            ->with('success', 'Surat KP4 Lama berhasil disimpan.');
    }

    public function edit(SuratKp4Old $suratKp4Old): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratKp4Old->load('pegawai', 'penandatangan', 'anggotaKeluarga', 'anak');

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_kp4_olds.edit', compact('asns', 'suratKp4Old', 'defaultPenandatanganId'));
    }

    public function update(Request $request, SuratKp4Old $suratKp4Old): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratKp4Old->update($validated);

        $this->syncAnggotaKeluarga($suratKp4Old, $request);
        $this->syncAnak($suratKp4Old, $request);

        return redirect()->route('surat-kp4-olds.print', $suratKp4Old)
            ->with('success', 'Surat KP4 Lama berhasil diperbarui.');
    }

    public function destroy(SuratKp4Old $suratKp4Old): RedirectResponse
    {
        $suratKp4Old->delete();

        return redirect()->route('surat-kp4-olds.index')
            ->with('success', 'Surat KP4 Lama berhasil dihapus.');
    }

    public function print(SuratKp4Old $suratKp4Old): View
    {
        $suratKp4Old->load('pegawai', 'penandatangan', 'anggotaKeluarga', 'anak');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_kp4_olds.print', compact('suratKp4Old', 'kopSuratBase64'));
    }

    public function printPage2(SuratKp4Old $suratKp4Old): View
    {
        $suratKp4Old->load('pegawai', 'anak');

        $pegawai = $suratKp4Old->pegawai;
        $jk = $pegawai->jk === 'L' ? 'Laki-Laki' : ($pegawai->jk === 'P' ? 'Perempuan' : '-');
        $namaAyah = $pegawai->jk === 'L' ? $pegawai->nama : ($pegawai->nama_suami_istri ?? '-');
        $namaIbu = $pegawai->jk === 'L' ? ($pegawai->nama_suami_istri ?? '-') : $pegawai->nama;

        return view('surat_kp4_olds.print_page2', compact('suratKp4Old', 'pegawai', 'jk', 'namaAyah', 'namaIbu'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'status_kepegawaian' => 'nullable|string|max:255',
            'masa_kerja_golongan' => 'nullable|string|max:255',
            'digaji_menurut' => 'nullable|string|max:255',
            'disamping_jabatan' => 'nullable|string|max:255',
            'penghasilan_disamping' => 'nullable|string|max:255',
            'pensiun_janda' => 'nullable|string|max:255',
            'kawin_sah' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);
    }

    private function syncAnggotaKeluarga(SuratKp4Old $suratKp4Old, Request $request): void
    {
        $suratKp4Old->anggotaKeluarga()->delete();

        $anggota = $request->input('anggota', []);
        if (! is_array($anggota)) {
            return;
        }

        foreach ($anggota as $item) {
            if (empty($item['nama'])) {
                continue;
            }

            $suratKp4Old->anggotaKeluarga()->create([
                'nama' => $item['nama'],
                'nama_suami_istri' => $item['nama_suami_istri'] ?? null,
                'tanggal_kelahiran' => $item['tanggal_kelahiran'] ?? null,
                'tanggal_perkawinan' => $item['tanggal_perkawinan'] ?? null,
                'pekerjaan' => $item['pekerjaan'] ?? null,
                'penghasilan_sebulan' => $item['penghasilan_sebulan'] ?? null,
                'keterangan' => $item['keterangan'] ?? null,
                'mendapat_tunjangan' => isset($item['mendapat_tunjangan']),
            ]);
        }
    }

    private function syncAnak(SuratKp4Old $suratKp4Old, Request $request): void
    {
        $suratKp4Old->anak()->delete();

        $anak = $request->input('anak', []);
        if (! is_array($anak)) {
            return;
        }

        foreach ($anak as $item) {
            if (empty($item['name'])) {
                continue;
            }

            $suratKp4Old->anak()->create([
                'name' => $item['name'],
                'anak' => $item['anak'] ?? null,
                'tgl_lahir' => $item['tgl_lahir'] ?? null,
                'perkawinan' => $item['perkawinan'] ?? null,
                'status_sekolah' => $item['status_sekolah'] ?? null,
                'status_beasiswa' => $item['status_beasiswa'] ?? null,
                'pekerjaan' => $item['pekerjaan'] ?? null,
                'kat' => $item['kat'] ?? 1,
                'tgl_mendinggal_cerai' => $item['tgl_meninggal_cerai'] ?? null,
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
