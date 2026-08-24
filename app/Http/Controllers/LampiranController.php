<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\Lampiran;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LampiranController extends Controller
{
    public function index(): View
    {
        $lampirans = Lampiran::latest()->paginate(10);

        return view('lampirans.index', compact('lampirans'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('lampirans.create', compact('asns', 'siswas', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'nomor' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'pegawai_ids' => 'nullable|array',
            'pegawai_ids.*' => 'exists:asns,id',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'penandatangan_an' => 'nullable|boolean',
        ]);

        $validated['penandatangan_an'] = $request->boolean('penandatangan_an');

        Lampiran::create($validated);

        return redirect()->route('lampirans.index')->with('success', 'Lampiran berhasil dibuat.');
    }

    public function edit(Lampiran $lampiran): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('lampirans.edit', compact('lampiran', 'asns', 'siswas', 'defaultPenandatanganId'));
    }

    public function update(Request $request, Lampiran $lampiran): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'nullable|string|max:255',
            'nomor' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'pegawai_ids' => 'nullable|array',
            'pegawai_ids.*' => 'exists:asns,id',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:data_siswa,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'penandatangan_an' => 'nullable|boolean',
        ]);

        $validated['penandatangan_an'] = $request->boolean('penandatangan_an');

        $lampiran->update($validated);

        return redirect()->route('lampirans.index')->with('success', 'Lampiran berhasil diperbarui.');
    }

    public function destroy(Lampiran $lampiran): RedirectResponse
    {
        $lampiran->delete();

        return redirect()->route('lampirans.index')->with('success', 'Lampiran berhasil dihapus.');
    }

    public function print(Lampiran $lampiran): View
    {
        return view('lampirans.print', compact('lampiran'));
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
