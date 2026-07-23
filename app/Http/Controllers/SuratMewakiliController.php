<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratMewakili;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratMewakiliController extends Controller
{
    public function index(): View
    {
        $suratMewakili = SuratMewakili::with(['penunjuk', 'ditunjuk'])
            ->latest()
            ->paginate(10);

        return view('surat_mewakili.index', compact('suratMewakili'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        return view('surat_mewakili.create', compact('asns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratMewakili = SuratMewakili::create($validated);

        return redirect()->route('surat-mewakili.print', $suratMewakili)
            ->with('success', 'Surat Penunjukan Mewakili berhasil disimpan.');
    }

    public function edit(SuratMewakili $suratMewakili): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratMewakili->load('penunjuk', 'ditunjuk');

        return view('surat_mewakili.edit', compact('asns', 'suratMewakili'));
    }

    public function update(Request $request, SuratMewakili $suratMewakili): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratMewakili->update($validated);

        return redirect()->route('surat-mewakili.print', $suratMewakili)
            ->with('success', 'Surat Penunjukan Mewakili berhasil diperbarui.');
    }

    public function destroy(SuratMewakili $suratMewakili): RedirectResponse
    {
        $suratMewakili->delete();

        return redirect()->route('surat-mewakili.index')
            ->with('success', 'Surat Penunjukan Mewakili berhasil dihapus.');
    }

    public function print(SuratMewakili $suratMewakili): View
    {
        $suratMewakili->load('penunjuk', 'ditunjuk');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_mewakili.print', compact('suratMewakili', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor' => 'nullable|string|max:100',
            'penunjuk_id' => 'nullable|exists:asns,id',
            'penunjuk_nama' => 'nullable|string|max:255',
            'penunjuk_nip' => 'nullable|string|max:255',
            'penunjuk_pangkat_gol' => 'nullable|string|max:255',
            'penunjuk_jabatan' => 'nullable|string|max:255',
            'ditunjuk_id' => 'nullable|exists:asns,id',
            'ditunjuk_nama' => 'nullable|string|max:255',
            'ditunjuk_nip' => 'nullable|string|max:255',
            'ditunjuk_instansi' => 'nullable|string|max:255',
            'ditunjuk_jabatan' => 'nullable|string|max:255',
            'keterangan_mewakili' => 'nullable|string',
            'penutup' => 'nullable|string',
            'dikeluarkan_di' => 'nullable|string|max:255',
            'tanggal_dikeluarkan' => 'nullable|date',
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date',
            'dikarenakan' => 'nullable|string',
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
