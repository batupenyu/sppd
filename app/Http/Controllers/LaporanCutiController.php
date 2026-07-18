<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LaporanCuti;
use App\Models\LogoSetting;
use App\Models\SuratCuti;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanCutiController extends Controller
{
    public function index(): View
    {
        $laporanCutis = LaporanCuti::with(['asn', 'penandatangan'])->latest()->paginate(10);

        return view('laporan_cutis.index', compact('laporanCutis'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('laporan_cutis.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'asn_id' => 'nullable|exists:asns,id',
            'tahun' => 'nullable|string|max:255',
            'alokasi_awal_tahun_n' => 'nullable|integer',
            'alokasi_awal_tahun_n_1' => 'nullable|integer',
            'alokasi_awal_tahun_n_2' => 'nullable|integer',
            'total_alokasi_awal' => 'nullable|integer',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);

        $laporanCuti = LaporanCuti::create($validated);

        return redirect()->route('laporan-cutis.print', $laporanCuti)
            ->with('success', 'Laporan Cuti berhasil disimpan.');
    }

    public function edit(LaporanCuti $laporanCuti): View
    {
        $asns = Asn::orderBy('nama')->get();
        $laporanCuti->load('penandatangan', 'asn');

        return view('laporan_cutis.edit', compact('asns', 'laporanCuti'));
    }

    public function update(Request $request, LaporanCuti $laporanCuti): RedirectResponse
    {
        $validated = $request->validate([
            'asn_id' => 'nullable|exists:asns,id',
            'tahun' => 'nullable|string|max:255',
            'alokasi_awal_tahun_n' => 'nullable|integer',
            'alokasi_awal_tahun_n_1' => 'nullable|integer',
            'alokasi_awal_tahun_n_2' => 'nullable|integer',
            'total_alokasi_awal' => 'nullable|integer',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);

        $laporanCuti->update($validated);

        return redirect()->route('laporan-cutis.print', $laporanCuti)
            ->with('success', 'Laporan Cuti berhasil diperbarui.');
    }

    public function destroy(LaporanCuti $laporanCuti): RedirectResponse
    {
        $laporanCuti->delete();

        return redirect()->route('laporan-cutis.index')->with('success', 'Laporan Cuti berhasil dihapus.');
    }

    public function print(LaporanCuti $laporanCuti): View
    {
        $laporanCuti->load('penandatangan', 'asn');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        $suratCutis = SuratCuti::where('pegawai_id', $laporanCuti->asn_id)
            ->whereNotNull('tanggal_mulai_cuti')
            ->whereNotNull('tanggal_selesai_cuti')
            ->orderBy('tanggal_mulai_cuti')
            ->get();

        $perPage = 10;
        $chunks = $suratCutis->chunk($perPage);

        $pages = [];
        $globalNumber = 1;
        foreach ($chunks as $chunk) {
            $rows = [];
            foreach ($chunk as $suratCuti) {
                $rows[] = [
                    'number' => $globalNumber++,
                    'surat_cuti' => $suratCuti,
                    'lhc' => $this->calculateLeaveDays($suratCuti->tanggal_mulai_cuti, $suratCuti->tanggal_selesai_cuti),
                    'atb_for_row' => '0',
                    'stb_for_row' => '0',
                ];
            }
            $pages[] = ['rows' => $rows];
        }

        if (empty($pages)) {
            $pages = [['rows' => []]];
        }

        $years = $laporanCuti->tahun ? explode(',', str_replace(' - ', ',', $laporanCuti->tahun)) : [date('Y')];
        $years = array_values(array_filter(array_map('trim', $years)));

        return view('laporan_cutis.print', compact(
            'laporanCuti',
            'kopSuratBase64',
            'pages',
            'years'
        ));
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
}
