<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratPenarikanSiswa;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratPenarikanSiswaController extends Controller
{
    public function index(): View
    {
        $suratPenarikanSiswas = SuratPenarikanSiswa::with(['penandatangan', 'pegawai'])
            ->latest()
            ->paginate(10);

        return view('surat_penarikan_siswas.index', compact('suratPenarikanSiswas'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_penarikan_siswas.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratPenarikanSiswa = SuratPenarikanSiswa::create($validated);

        return redirect()->route('surat-penarikan-siswas.print', $suratPenarikanSiswa)
            ->with('success', 'Surat Penarikan Siswa berhasil disimpan.');
    }

    public function edit(SuratPenarikanSiswa $suratPenarikanSiswa): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratPenarikanSiswa->load('penandatangan', 'pegawai');

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_penarikan_siswas.edit', compact('asns', 'suratPenarikanSiswa', 'defaultPenandatanganId'));
    }

    public function update(Request $request, SuratPenarikanSiswa $suratPenarikanSiswa): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratPenarikanSiswa->update($validated);

        return redirect()->route('surat-penarikan-siswas.print', $suratPenarikanSiswa)
            ->with('success', 'Surat Penarikan Siswa berhasil diperbarui.');
    }

    public function destroy(SuratPenarikanSiswa $suratPenarikanSiswa): RedirectResponse
    {
        $suratPenarikanSiswa->delete();

        return redirect()->route('surat-penarikan-siswas.index')
            ->with('success', 'Surat Penarikan Siswa berhasil dihapus.');
    }

    public function print(SuratPenarikanSiswa $suratPenarikanSiswa): View
    {
        $suratPenarikanSiswa->load('penandatangan', 'pegawai');

        return view('surat_penarikan_siswas.print', compact('suratPenarikanSiswa'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'nama_sekolah_asal' => 'nullable|string|max:255',
            'nama_siswa' => 'nullable|string|max:255',
            'nis' => 'nullable|string|max:255',
            'nisn' => 'nullable|string|max:255',
            'kelas_jurusan' => 'nullable|string|max:255',
            'nama_orang_tua' => 'nullable|string|max:255',
            'pekerjaan_orang_tua' => 'nullable|string|max:255',
            'alamat_rumah' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'tempat_tanggal_lahir' => 'nullable|string|max:255',
            'nama_sekolah_tujuan' => 'nullable|string|max:255',
            'alasan' => 'nullable|string',
            'nama_kota_sekolah' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'nama_kepala_sekolah' => 'nullable|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:255',
            'nama_wilayah_cabdinas' => 'nullable|string|max:255',
            'nama_kota_cabdin' => 'nullable|string|max:255',
            'nomor_surat_cabdin' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'nama_kepala_cabdinas' => 'nullable|string|max:255',
            'nip_kepala_cabdinas' => 'nullable|string|max:255',
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
