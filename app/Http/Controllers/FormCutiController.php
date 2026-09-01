<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\FormCuti;
use App\Models\HariLibur;
use App\Models\LaporanCuti;
use App\Models\SuratCuti;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormCutiController extends Controller
{
    public function index(): View
    {
        $formCutis = FormCuti::with(['pegawai', 'kepalaSekolah', 'kepalaCabang'])->latest()->paginate(10);

        return view('form_cutis.index', compact('formCutis'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('form_cutis.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'jenis_cuti' => 'nullable|string|max:255',
            'alasan_cuti' => 'nullable|string',
            'tanggal_mulai_cuti' => 'nullable|date',
            'tanggal_selesai_cuti' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'kepala_sekolah_id' => 'nullable|exists:asns,id',
            'kepala_cabang_id' => 'nullable|exists:asns,id',
            'alamat_cuti' => 'nullable|string',
            'telepon' => 'nullable|string|max:255',
            'plt_plh' => 'nullable|string|in:Plt,Plh',
            'plt_plh_kepala_cabang' => 'nullable|string|in:Plt,Plh',
        ]);

        $validated['jumlah_hari'] = $this->calculateLeaveDays(
            $validated['tanggal_mulai_cuti'] ?? null,
            $validated['tanggal_selesai_cuti'] ?? null
        );

        $formCuti = FormCuti::create($validated);

        return redirect()->route('form-cutis.print', $formCuti)
            ->with('success', 'Form Cuti berhasil disimpan.');
    }

    public function edit(FormCuti $formCuti): View
    {
        $asns = Asn::orderBy('nama')->get();
        $formCuti->load('pegawai', 'kepalaSekolah', 'kepalaCabang');

        return view('form_cutis.edit', compact('asns', 'formCuti'));
    }

    public function update(Request $request, FormCuti $formCuti): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'jenis_cuti' => 'nullable|string|max:255',
            'alasan_cuti' => 'nullable|string',
            'tanggal_mulai_cuti' => 'nullable|date',
            'tanggal_selesai_cuti' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'kepala_sekolah_id' => 'nullable|exists:asns,id',
            'kepala_cabang_id' => 'nullable|exists:asns,id',
            'alamat_cuti' => 'nullable|string',
            'telepon' => 'nullable|string|max:255',
            'plt_plh' => 'nullable|string|in:Plt,Plh',
            'plt_plh_kepala_cabang' => 'nullable|string|in:Plt,Plh',
        ]);

        $validated['jumlah_hari'] = $this->calculateLeaveDays(
            $validated['tanggal_mulai_cuti'] ?? null,
            $validated['tanggal_selesai_cuti'] ?? null
        );

        $formCuti->update($validated);

        return redirect()->route('form-cutis.print', $formCuti)
            ->with('success', 'Form Cuti berhasil diperbarui.');
    }

    public function destroy(FormCuti $formCuti): RedirectResponse
    {
        $formCuti->delete();

        return redirect()->route('form-cutis.index')->with('success', 'Form Cuti berhasil dihapus.');
    }

    public function print(FormCuti $formCuti): View
    {
        $formCuti->load('pegawai', 'kepalaSekolah', 'kepalaCabang');

        $currentYear = Carbon::now()->year;
        $laporanCuti = LaporanCuti::where('asn_id', $formCuti->pegawai_id)
            ->where('tahun', $currentYear)
            ->first();

        $alokasiN2 = (int) ($laporanCuti->alokasi_awal_tahun_n_2 ?? 0);
        $alokasiN1 = (int) ($laporanCuti->alokasi_awal_tahun_n_1 ?? 0);
        $alokasiN  = (int) ($laporanCuti->alokasi_awal_tahun_n ?? 0);

        $akumulasiTotal = $this->calculateAkumulasiCutiTahunan(
            $formCuti->pegawai_id,
            $formCuti->tanggal_mulai_cuti
        );

        $remaining = $akumulasiTotal;
        $sisaN2 = max(0, $alokasiN2 - $remaining);
        $remaining = max(0, $remaining - $alokasiN2);
        $sisaN1 = max(0, $alokasiN1 - $remaining);
        $remaining = max(0, $remaining - $alokasiN1);
        $sisaN  = max(0, $alokasiN - $remaining);

        return view('form_cutis.print', compact(
            'formCuti',
            'laporanCuti',
            'akumulasiTotal',
            'sisaN2',
            'sisaN1',
            'sisaN',
        ));
    }

    private function calculateAkumulasiCutiTahunan(?int $pegawaiId, $beforeDate = null): int
    {
        if (! $pegawaiId) {
            return 0;
        }

        $query = SuratCuti::where('pegawai_id', $pegawaiId)
            ->where('jenis_cuti', 'Cuti Tahunan')
            ->whereNotNull('tanggal_mulai_cuti')
            ->whereNotNull('tanggal_selesai_cuti');

        if ($beforeDate) {
            $query->where('tanggal_mulai_cuti', '<=', $beforeDate);
        }

        $suratCutis = $query->orderBy('tanggal_mulai_cuti')->get();

        $formCutiQuery = FormCuti::where('pegawai_id', $pegawaiId)
            ->where('jenis_cuti', 'Cuti Tahunan')
            ->whereNotNull('tanggal_mulai_cuti')
            ->whereNotNull('tanggal_selesai_cuti');

        if ($beforeDate) {
            $formCutiQuery->where('tanggal_mulai_cuti', '<=', $beforeDate);
        }

        $formCutis = $formCutiQuery->orderBy('tanggal_mulai_cuti')->get();

        $suratRanges = $suratCutis->map(function ($sc) {
            return [
                Carbon::parse($sc->tanggal_mulai_cuti)->startOfDay(),
                Carbon::parse($sc->tanggal_selesai_cuti)->startOfDay(),
            ];
        })->toArray();

        $akumulasiTotal = 0;

        foreach ($suratCutis as $sc) {
            $akumulasiTotal += $this->calculateWorkingDays(
                $sc->tanggal_mulai_cuti,
                $sc->tanggal_selesai_cuti
            );
        }

        foreach ($formCutis as $fc) {
            $fcStart = Carbon::parse($fc->tanggal_mulai_cuti)->startOfDay();
            $fcEnd = Carbon::parse($fc->tanggal_selesai_cuti)->startOfDay();

            $overlaps = false;
            foreach ($suratRanges as [$scStart, $scEnd]) {
                if ($fcStart->lte($scEnd) && $fcEnd->gte($scStart)) {
                    $overlaps = true;
                    break;
                }
            }

            if (! $overlaps) {
                $akumulasiTotal += $this->calculateWorkingDays(
                    $fc->tanggal_mulai_cuti,
                    $fc->tanggal_selesai_cuti
                );
            }
        }

        return $akumulasiTotal;
    }

    private function calculateWorkingDays($mulai, $selesai): int
    {
        if (! $mulai || ! $selesai) {
            return 0;
        }

        $start = Carbon::parse($mulai)->startOfDay();
        $end = Carbon::parse($selesai)->startOfDay();

        if ($end->lt($start)) {
            [$start, $end] = [$end, $start];
        }

        $holidays = HariLibur::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->pluck('tanggal')
            ->toArray();

        $days = 0;
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if ($date->isWeekend() || in_array($date->toDateString(), $holidays)) {
                continue;
            }
            $days++;
        }

        return $days;
    }

    private function calculateLeaveDays($mulai, $selesai): int
    {
        if (! $mulai || ! $selesai) {
            return 0;
        }

        $start = Carbon::parse($mulai);
        $end = Carbon::parse($selesai);

        return abs($start->diffInDays($end)) + 1;
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
