<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratTugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratTugasController extends Controller
{
    public function index(): View
    {
        $suratTugas = SuratTugas::latest()->paginate(10);

        return view('surat_tugas.index', compact('suratTugas'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_tugas.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor' => 'nullable|string|max:100',
            'dasar' => 'nullable|string',
            'peserta' => 'nullable|array',
            'peserta.*' => 'exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'untuk_1' => 'nullable|string',
            'untuk_2' => 'nullable|string',
            'untuk_3' => 'nullable|string',
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
        ]);

        SuratTugas::create($validated);

        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil dibuat.');
    }

    public function edit(SuratTugas $suratTugas): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_tugas.edit', compact('suratTugas', 'asns', 'defaultPenandatanganId'));
    }

    public function update(Request $request, SuratTugas $suratTugas): RedirectResponse
    {
        $validated = $request->validate([
            'nomor' => 'nullable|string|max:100',
            'dasar' => 'nullable|string',
            'peserta' => 'nullable|array',
            'peserta.*' => 'exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'untuk_1' => 'nullable|string',
            'untuk_2' => 'nullable|string',
            'untuk_3' => 'nullable|string',
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
        ]);

        $suratTugas->update($validated);

        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil diperbarui.');
    }

    public function destroy(SuratTugas $suratTugas): RedirectResponse
    {
        $suratTugas->delete();

        return redirect()->route('surat-tugas.index')->with('success', 'Surat Tugas berhasil dihapus.');
    }

    public function print(SuratTugas $suratTugas): View
    {
        $suratTugas->load('penandatangan');
        $peserta = $suratTugas->getPeserta();

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
        $mulai = $suratTugas->tanggal_mulai;
        $selesai = $suratTugas->tanggal_selesai;

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
            } else {
                $tanggalText = 'tanggal '.$fmt($mulai).' s.d tanggal '.$fmt($selesai);
            }
        }

        $tanggalDikeluarkan = null;
        if ($suratTugas->tanggal_dikeluarkan) {
            $tanggalDikeluarkan = $fmt($suratTugas->tanggal_dikeluarkan);
        }

        return view('surat_tugas.print', compact('suratTugas', 'peserta', 'kopSuratBase64', 'selamaHuruf', 'tanggalText', 'tanggalDikeluarkan'));
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
