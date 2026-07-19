<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\LogoSetting;
use App\Models\SuratNodin;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratNodinController extends Controller
{
    public function index(): View
    {
        $suratNodins = SuratNodin::with(['penandatangan'])
            ->latest()
            ->paginate(10);

        return view('surat_nodins.index', compact('suratNodins'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $logos = \App\Models\LogoSetting::orderBy('name')->get();

        return view('surat_nodins.create', compact('asns', 'siswas', 'logos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratNodin = SuratNodin::create($validated);
        $this->syncPeserta($suratNodin, $request);

        return redirect()->route('surat-nodins.print', $suratNodin)
            ->with('success', 'Surat Nodin berhasil disimpan.');
    }

    public function edit(SuratNodin $suratNodin): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $logos = \App\Models\LogoSetting::orderBy('name')->get();
        $suratNodin->load('penandatangan', 'pesertaSuratUsulans');

        return view('surat_nodins.edit', compact('asns', 'siswas', 'logos', 'suratNodin'));
    }

    public function update(Request $request, SuratNodin $suratNodin): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratNodin->update($validated);
        $suratNodin->pesertaSuratUsulans()->delete();
        $this->syncPeserta($suratNodin, $request);

        return redirect()->route('surat-nodins.print', $suratNodin)
            ->with('success', 'Surat Nodin berhasil diperbarui.');
    }

    public function destroy(SuratNodin $suratNodin): RedirectResponse
    {
        $suratNodin->delete();

        return redirect()->route('surat-nodins.index')
            ->with('success', 'Surat Nodin berhasil dihapus.');
    }

    public function print(SuratNodin $suratNodin): View
    {
        $suratNodin->load('penandatangan', 'pesertaSuratUsulans.pegawai', 'pesertaSuratUsulans.siswa');

        $kopSuratBase64 = null;
        $logoName = $suratNodin->kop_surat ?: 'kop_smk';
        $logo = LogoSetting::where('name', $logoName)->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_nodins.print', compact('suratNodin', 'kopSuratBase64'));
    }

    public function lampiran(SuratNodin $suratNodin): View
    {
        $suratNodin->load('penandatangan', 'pesertaSuratUsulans.pegawai', 'pesertaSuratUsulans.siswa');

        return view('surat_nodins.lampiran', compact('suratNodin'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor' => 'nullable|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'hal' => 'nullable|string|max:255',
            'kepada' => 'nullable|string|max:255',
            'dari' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'dasar_surat' => 'nullable|string',
            'isi_surat' => 'nullable|string',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'kop_surat' => 'nullable|string|max:255',
            'pegawai_ids' => 'nullable|array',
            'pegawai_ids.*' => 'exists:asns,id',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'tanggal_kegiatan' => 'nullable|date',
            'tempat_kegiatan' => 'nullable|string|max:255',
        ]);
    }

    private function syncPeserta(SuratNodin $suratNodin, Request $request): void
    {
        $suratNodin->pesertaSuratUsulans()->delete();

        $pegawaiIds = $request->input('pegawai_ids', []);
        $siswaIds = $request->input('siswa_ids', []);
        $tanggalKegiatan = $request->input('tanggal_kegiatan') ?: null;
        $tempatKegiatan = $request->input('tempat_kegiatan') ?: null;

        foreach ($pegawaiIds as $pegawaiId) {
            $suratNodin->pesertaSuratUsulans()->create([
                'pegawai_id' => $pegawaiId,
                'siswa_id' => null,
                'tanggal_kegiatan' => $tanggalKegiatan,
                'tempat_kegiatan' => $tempatKegiatan,
            ]);
        }

        foreach ($siswaIds as $siswaId) {
            $suratNodin->pesertaSuratUsulans()->create([
                'pegawai_id' => null,
                'siswa_id' => $siswaId,
                'tanggal_kegiatan' => $tanggalKegiatan,
                'tempat_kegiatan' => $tempatKegiatan,
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
