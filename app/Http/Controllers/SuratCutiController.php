<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratCuti;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratCutiController extends Controller
{
    public function index(): View
    {
        $suratCutis = SuratCuti::with(['penandatangan', 'pegawai'])->latest()->paginate(10);

        return view('surat_cutis.index', compact('suratCutis'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_cutis.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'sifat_surat' => 'nullable|string|max:255',
            'lampiran_surat' => 'nullable|string|max:255',
            'perihal_surat' => 'nullable|string|max:255',
            'jenis_cuti' => 'nullable|string|max:255',
            'tujuan_surat' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'alasan_cuti' => 'nullable|string',
            'tanggal_mulai_cuti' => 'nullable|date',
            'tanggal_selesai_cuti' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);

        $suratCuti = SuratCuti::create($validated);

        return redirect()->route('surat-cutis.print', $suratCuti)
            ->with('success', 'Surat Cuti berhasil disimpan.');
    }

    public function edit(SuratCuti $suratCuti): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratCuti->load('penandatangan', 'pegawai');

        return view('surat_cutis.edit', compact('asns', 'suratCuti'));
    }

    public function update(Request $request, SuratCuti $suratCuti): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'sifat_surat' => 'nullable|string|max:255',
            'lampiran_surat' => 'nullable|string|max:255',
            'perihal_surat' => 'nullable|string|max:255',
            'jenis_cuti' => 'nullable|string|max:255',
            'tujuan_surat' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'alasan_cuti' => 'nullable|string',
            'tanggal_mulai_cuti' => 'nullable|date',
            'tanggal_selesai_cuti' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);

        $suratCuti->update($validated);

        return redirect()->route('surat-cutis.print', $suratCuti)
            ->with('success', 'Surat Cuti berhasil diperbarui.');
    }

    public function destroy(SuratCuti $suratCuti): RedirectResponse
    {
        $suratCuti->delete();

        return redirect()->route('surat-cutis.index')->with('success', 'Surat Cuti berhasil dihapus.');
    }

    public function print(SuratCuti $suratCuti): View
    {
        $suratCuti->load('penandatangan', 'pegawai');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:' . ($logo->mime ?: 'image/png') . ';base64,' . base64_encode($logo->image);
        }

        $leaveDurationText = $this->formatLeaveDuration($suratCuti);

        return view('surat_cutis.print', compact('suratCuti', 'kopSuratBase64', 'leaveDurationText'));
    }

    private function formatLeaveDuration(SuratCuti $suratCuti): string
    {
        $mulai = $suratCuti->tanggal_mulai_cuti;
        $selesai = $suratCuti->tanggal_selesai_cuti;

        if (!$mulai || !$selesai) {
            return '';
        }

        $fmt = [self::class, 'formatTanggal'];

        if ($mulai->isSameDay($selesai)) {
            $days = 1;
            $daysTerbilang = 'satu';
        } else {
            $days = $mulai->diffInDays($selesai) + 1;
            $daysTerbilang = $this->terbilangHari($days);
        }

        return 'selama ' . $days . ' (' . $daysTerbilang . ') hari, yaitu tanggal ' . $fmt($mulai, '%d %B %Y') . ' sampai dengan tanggal ' . $fmt($selesai, '%d %B %Y');
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
            return $ones[$n - 10] . ' belas';
        }
        if ($n < 100) {
            $tens = intdiv($n, 10);
            $unit = $n % 10;
            $tensWord = [
                2 => 'dua puluh', 3 => 'tiga puluh', 4 => 'empat puluh',
                5 => 'lima puluh', 6 => 'enam puluh', 7 => 'tujuh puluh',
                8 => 'delapan puluh', 9 => 'sembilan puluh',
            ];
            return $tensWord[$tens] . ($unit ? ' ' . $ones[$unit] : '');
        }

        return (string) $n;
    }

    public static function formatTanggal($date, string $format = '%d %B %Y'): string
    {
        if (empty($date)) {
            return '-';
        }

        $carbon = $date instanceof \Carbon\CarbonInterface
            ? $date
            : \Carbon\Carbon::parse($date);

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
