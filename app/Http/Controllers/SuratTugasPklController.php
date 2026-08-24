<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\LogoSetting;
use App\Models\SuratTugasPkl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratTugasPklController extends Controller
{
    public function index(): View
    {
        $suratTugasPkls = SuratTugasPkl::latest()->paginate(10);

        return view('surat_tugas_pkls.index', compact('suratTugasPkls'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_tugas_pkls.create', compact('asns', 'siswas', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor' => 'nullable|string|max:100',
            'dasar' => 'nullable|string',
            'pegawai_ids' => 'nullable|array',
            'pegawai_ids.*' => 'exists:asns,id',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'untuk_1' => 'nullable|string',
            'untuk_2' => 'nullable|string',
            'untuk_3' => 'nullable|string',
            'untuk_4' => 'nullable|string',
            'untuk_5' => 'nullable|string',
            'kegiatan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'pukul' => 'nullable|string|max:50',
            'tempat' => 'nullable|string',
            'sumber_dana' => 'nullable|string|max:100',
            'tahun_anggaran' => 'nullable|string|max:10',
            'dikeluarkan_di' => 'nullable|string|max:255',
            'tanggal_dikeluarkan' => 'nullable|date',
            'nama_penandatangan' => 'nullable|string|max:255',
            'nip_penandatangan' => 'nullable|string|max:255',
            'penandatangan_plt' => 'nullable|boolean',
            'penandatangan_an' => 'nullable|boolean',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);

        SuratTugasPkl::create($validated);

        return redirect()->route('surat-tugas-pkls.index')->with('success', 'Surat Tugas PKL berhasil dibuat.');
    }

    public function edit(SuratTugasPkl $suratTugasPkl): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_tugas_pkls.edit', compact('suratTugasPkl', 'asns', 'siswas', 'defaultPenandatanganId'));
    }

    public function update(Request $request, SuratTugasPkl $suratTugasPkl): RedirectResponse
    {
        $validated = $request->validate([
            'nomor' => 'nullable|string|max:100',
            'dasar' => 'nullable|string',
            'pegawai_ids' => 'nullable|array',
            'pegawai_ids.*' => 'exists:asns,id',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'untuk_1' => 'nullable|string',
            'untuk_2' => 'nullable|string',
            'untuk_3' => 'nullable|string',
            'untuk_4' => 'nullable|string',
            'untuk_5' => 'nullable|string',
            'kegiatan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'pukul' => 'nullable|string|max:50',
            'tempat' => 'nullable|string',
            'sumber_dana' => 'nullable|string|max:100',
            'tahun_anggaran' => 'nullable|string|max:10',
            'dikeluarkan_di' => 'nullable|string|max:255',
            'tanggal_dikeluarkan' => 'nullable|date',
            'nama_penandatangan' => 'nullable|string|max:255',
            'nip_penandatangan' => 'nullable|string|max:255',
            'penandatangan_plt' => 'nullable|boolean',
            'penandatangan_an' => 'nullable|boolean',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);

        $suratTugasPkl->update($validated);

        return redirect()->route('surat-tugas-pkls.index')->with('success', 'Surat Tugas PKL berhasil diperbarui.');
    }

    public function destroy(SuratTugasPkl $suratTugasPkl): RedirectResponse
    {
        $suratTugasPkl->delete();

        return redirect()->route('surat-tugas-pkls.index')->with('success', 'Surat Tugas PKL berhasil dihapus.');
    }

    public function print(SuratTugasPkl $suratTugasPkl): View
    {
        $suratTugasPkl->load('penandatangan');
        $pegawai = $suratTugasPkl->getPegawai();
        $siswa = $suratTugasPkl->getSiswa();

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $fmt = function ($d) use ($months) {
            if (! $d) {
                return null;
            }

            return $d->format('d').' '.$months[(int) $d->format('n')].' '.$d->format('Y');
        };
        $mulai = $suratTugasPkl->tanggal_mulai;
        $selesai = $suratTugasPkl->tanggal_selesai;

        $selama = null;
        $selamaHuruf = null;
        if ($mulai && $selesai) {
            $selama = $mulai->diffInDays($selesai) + 1;
            $selamaHuruf = $selama.' ('.$this->terbilangHari($selama).') hari';
        }

        $tanggalText = null;
        if ($mulai && $selesai) {
            if ($mulai->format('Y-m-d') === $selesai->format('Y-m-d')) {
                $tanggalText = 'tanggal '.$fmt($mulai);
            } elseif ($mulai->format('Y-m') === $selesai->format('Y-m')) {
                $tanggalText = 'tanggal '.$mulai->format('d').' s.d '.$selesai->format('d').' '.$months[(int) $mulai->format('n')].' '.$mulai->format('Y');
            } else {
                $tanggalText = 'tanggal '.$fmt($mulai).' s.d tanggal '.$fmt($selesai);
            }
        }

        $tanggalDikeluarkan = null;
        if ($suratTugasPkl->tanggal_dikeluarkan) {
            $tanggalDikeluarkan = $fmt($suratTugasPkl->tanggal_dikeluarkan);
        }

        return view('surat_tugas_pkls.print', compact('suratTugasPkl', 'pegawai', 'siswa', 'kopSuratBase64', 'selamaHuruf', 'tanggalText', 'tanggalDikeluarkan'));
    }

    private function terbilangHari(int $n): string
    {
        $ones = [
            0 => '', 1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat',
            5 => 'lima', 6 => 'enam', 7 => 'tujuh', 8 => 'delapan', 9 => 'sembilan',
            10 => 'sepuluh', 11 => 'sebelas',
        ];

        if ($n < 12) {
            return $ones[$n];
        }
        if ($n < 20) {
            return $ones[$n - 10].' belas';
        }
        if ($n < 100) {
            $tens = intdiv($n, 10);
            $unit = $n % 10;
            $tensWord = [
                2 => 'dua puluh', 3 => 'tiga puluh', 4 => 'empat puluh',
                5 => 'lima puluh', 6 => 'enam puluh', 7 => 'tujuh puluh',
                8 => 'delapan puluh', 9 => 'sembilan puluh',
            ];

            return $tensWord[$tens].($unit ? ' '.$ones[$unit] : '');
        }

        return (string) $n;
    }
}
