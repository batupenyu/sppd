<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DrhSatyalancana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrhSatyalancanaController extends Controller
{
    public function index(): View
    {
        $drhs = DrhSatyalancana::with('asn')->latest()->paginate(10);

        return view('drh_satyalancana.index', compact('drhs'));
    }

    public function create(Request $request): View
    {
        $asns = Asn::orderBy('nama')->get();
        $selectedAsn = null;

        if ($request->filled('asn_id')) {
            $selectedAsn = Asn::find($request->input('asn_id'));
        }

        return view('drh_satyalancana.create', compact('asns', 'selectedAsn'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'asn_id' => 'required|exists:asns,id',
            'nip_lama' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'tmt_pangkat' => 'nullable|date',
            'no_sk_cpns' => 'nullable|string|max:255',
            'tmt_cpns' => 'nullable|date',
            'jabatan_terakhir' => 'nullable|string|max:255',
            'tmt_jabatan' => 'nullable|date',
            'tanda_kehormatan' => 'nullable|string|max:255',
            'tgl_kepres' => 'nullable|date',
            'no_kepres' => 'nullable|string|max:255',
            'hukuman_disiplin' => 'nullable|string',
            'cltn' => 'nullable|string',
            'atasan_nama' => 'nullable|string|max:255',
            'atasan_nip' => 'nullable|string|max:50',
        ]);

        $drh = DrhSatyalancana::create($validated);

        return redirect()->route('drh-satyalancana.print', $drh)
            ->with('success', 'Data DRH Satyalancana berhasil disimpan.');
    }

    public function edit(DrhSatyalancana $drh): View
    {
        $asns = Asn::orderBy('nama')->get();
        $drh->load('asn');

        return view('drh_satyalancana.edit', compact('asns', 'drh'));
    }

    public function update(Request $request, DrhSatyalancana $drh): RedirectResponse
    {
        $validated = $request->validate([
            'asn_id' => 'required|exists:asns,id',
            'nip_lama' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'tmt_pangkat' => 'nullable|date',
            'no_sk_cpns' => 'nullable|string|max:255',
            'tmt_cpns' => 'nullable|date',
            'jabatan_terakhir' => 'nullable|string|max:255',
            'tmt_jabatan' => 'nullable|date',
            'tanda_kehormatan' => 'nullable|string|max:255',
            'tgl_kepres' => 'nullable|date',
            'no_kepres' => 'nullable|string|max:255',
            'hukuman_disiplin' => 'nullable|string',
            'cltn' => 'nullable|string',
            'atasan_nama' => 'nullable|string|max:255',
            'atasan_nip' => 'nullable|string|max:50',
        ]);

        $drh->update($validated);

        return redirect()->route('drh-satyalancana.print', $drh)
            ->with('success', 'Data DRH Satyalancana berhasil diperbarui.');
    }

    public function destroy(DrhSatyalancana $drh): RedirectResponse
    {
        $drh->delete();

        return redirect()->route('drh-satyalancana.index')->with('success', 'Data DRH Satyalancana berhasil dihapus.');
    }

    public function print(DrhSatyalancana $drh): View
    {
        $drh->load('asn');

        return view('drh_satyalancana.print', compact('drh'));
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
