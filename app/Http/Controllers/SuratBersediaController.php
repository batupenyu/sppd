<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\LogoSetting;
use App\Models\SuratBersedia;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratBersediaController extends Controller
{
    public function index(): View
    {
        $suratBersedias = SuratBersedia::latest()->paginate(10);

        return view('surat_bersedias.index', compact('suratBersedias'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_bersedias.create', compact('asns', 'defaultPenandatanganId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratBersedia = SuratBersedia::create($validated);

        return redirect()->route('surat-bersedias.print', $suratBersedia)
            ->with('success', 'Surat Bersedia PPLK II berhasil disimpan.');
    }

    public function edit(SuratBersedia $suratBersedia): View
    {
        $asns = Asn::orderBy('nama')->get();
        $defaultPenandatanganId = Asn::defaultPenandatanganId();

        return view('surat_bersedias.edit', compact('asns', 'suratBersedia', 'defaultPenandatanganId'));
    }

    public function update(Request $request, SuratBersedia $suratBersedia): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratBersedia->update($validated);

        return redirect()->route('surat-bersedias.print', $suratBersedia)
            ->with('success', 'Surat Bersedia PPLK II berhasil diperbarui.');
    }

    public function destroy(SuratBersedia $suratBersedia): RedirectResponse
    {
        $suratBersedia->delete();

        return redirect()->route('surat-bersedias.index')
            ->with('success', 'Surat Bersedia PPLK II berhasil dihapus.');
    }

    public function print(SuratBersedia $suratBersedia): View
    {
        $suratBersedia->load('pegawai', 'penandatangan');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_bersedias.print', compact('suratBersedia', 'kopSuratBase64'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'nama' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'hp_wa' => 'nullable|string|max:255',
            'status' => 'required|in:bersedia,tidak_bersedia',
            'isi_surat' => 'nullable|string',
            'penutup_surat' => 'nullable|string',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'pegawai_id' => 'nullable|exists:asns,id',
            'penandatangan_id' => 'nullable|exists:asns,id',
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
