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
    private const KETENTUAN_DEFAULT = "Dalam melaksanakan tugas harus sesuai dengan ketentuan yang berlaku, jika ada hal - hal prinsip harus dikonsultasikan dengan Kepala Dinas Pendidikan Provinsi Kepulauan Bangka Belitung atau menunggu Kepala Sekolah kembali bertugas.\nSurat Penunjukan mewakili ini berlaku selama 3 (tiga) hari tanggal 23 s.d 25 April 2026\natau sampai dengan kembalinya Kepala Sekolah dalam melaksanakan tugas.";

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
        $ketentuanDefault = self::KETENTUAN_DEFAULT;

        return view('surat_mewakili.create', compact('asns', 'ketentuanDefault'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);
        $validated['ketentuan'] = $this->ketentuanToArray($request);

        $suratMewakili = SuratMewakili::create($validated);

        return redirect()->route('surat-mewakili.print', $suratMewakili)
            ->with('success', 'Surat Penunjukan Mewakili berhasil disimpan.');
    }

    public function edit(SuratMewakili $suratMewakili): View
    {
        $asns = Asn::orderBy('nama')->get();
        $suratMewakili->load('penunjuk', 'ditunjuk');
        $ketentuanDefault = self::KETENTUAN_DEFAULT;

        return view('surat_mewakili.edit', compact('asns', 'suratMewakili', 'ketentuanDefault'));
    }

    public function update(Request $request, SuratMewakili $suratMewakili): RedirectResponse
    {
        $validated = $this->validateData($request);
        $validated['ketentuan'] = $this->ketentuanToArray($request);

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
            'keterangan_menunjuk' => 'nullable|string',
            'keterangan_mewakili' => 'nullable|string',
            'ketentuan' => 'nullable|string',
            'penutup' => 'nullable|string',
            'dikeluarkan_di' => 'nullable|string|max:255',
            'tanggal_dikeluarkan' => 'nullable|date',
        ]);
    }

    private function ketentuanToArray(Request $request): array
    {
        $raw = $request->input('ketentuan', '');
        if (! is_string($raw)) {
            return [];
        }

        return collect(explode("\n", $raw))
            ->map(fn ($line) => trim($line))
            ->filter(fn ($line) => $line !== '')
            ->values()
            ->all();
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

    public static function ketentuanDefaultText(): string
    {
        return self::KETENTUAN_DEFAULT;
    }
}
