<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\FormCuti;
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

        return view('form_cutis.print', compact('formCuti'));
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
