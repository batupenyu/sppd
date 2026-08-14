<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\PersetujuanMagang;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersetujuanMagangController extends Controller
{
    public function index(): View
    {
        $persetujuanMagangs = PersetujuanMagang::with('penandatangan')
            ->latest()
            ->paginate(10);

        return view('persetujuan_magangs.index', compact('persetujuanMagangs'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('persetujuan_magangs.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $persetujuanMagang = PersetujuanMagang::create($validated);

        return redirect()->route('persetujuan-magangs.print', $persetujuanMagang)
            ->with('success', 'Surat Persetujuan Magang berhasil disimpan.');
    }

    public function edit(PersetujuanMagang $persetujuanMagang): View
    {
        $asns = Asn::orderBy('nama')->get();
        $persetujuanMagang->load('penandatangan');

        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('persetujuan_magangs.edit', compact('asns', 'persetujuanMagang', 'defaultPenandatanganId'));
    }

    public function update(Request $request, PersetujuanMagang $persetujuanMagang): RedirectResponse
    {
        $validated = $this->validateData($request);

        $persetujuanMagang->update($validated);

        return redirect()->route('persetujuan-magangs.print', $persetujuanMagang)
            ->with('success', 'Surat Persetujuan Magang berhasil diperbarui.');
    }

    public function destroy(PersetujuanMagang $persetujuanMagang): RedirectResponse
    {
        $persetujuanMagang->delete();

        return redirect()->route('persetujuan-magangs.index')
            ->with('success', 'Surat Persetujuan Magang berhasil dihapus.');
    }

    public function print(PersetujuanMagang $persetujuanMagang): View
    {
        $persetujuanMagang->load('penandatangan');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('persetujuan_magangs.print', compact('persetujuanMagang', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'perihal' => 'nullable|string|max:255',
            'tujuan_surat' => 'nullable|string',
            'nomor_surat_kampus' => 'nullable|string|max:255',
            'tanggal_surat_kampus' => 'nullable|date',
            'nama_instansi' => 'nullable|string|max:255',
            'alamat_instansi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'mahasiswas' => 'nullable|array',
            'mahasiswas.*.nama' => 'nullable|string|max:255',
            'mahasiswas.*.nim' => 'nullable|string|max:255',
            'mahasiswas.*.program_studi' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'penandatangan_id' => 'nullable|exists:asns,id',
        ]);

        if (empty($validated['mahasiswas'])) {
            $validated['mahasiswas'] = [];
        }

        return $validated;
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
