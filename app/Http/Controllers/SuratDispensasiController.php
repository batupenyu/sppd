<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\LogoSetting;
use App\Models\SuratDispensasi;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratDispensasiController extends Controller
{
    public function index(): View
    {
        $suratDispensasis = SuratDispensasi::with(['penandatangan'])->latest()->paginate(10);

        return view('surat_dispensasis.index', compact('suratDispensasis'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();

        return view('surat_dispensasis.create', compact('asns', 'siswas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'nama_kegiatan' => 'nullable|string|max:255',
            'hari_tanggal' => 'nullable|string|max:255',
            'waktu' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'peserta_select' => 'nullable|array',
            'peserta_select.*' => 'string',
        ]);

        $suratDispensasi = SuratDispensasi::create($validated);

        if (! empty($validated['peserta_select'])) {
            foreach ($validated['peserta_select'] as $value) {
                if (str_starts_with($value, 'siswa_')) {
                    $id = (int) str_replace('siswa_', '', $value);
                    $siswa = DataSiswa::find($id);
                    if ($siswa) {
                        $suratDispensasi->pesertaDispensasis()->create([
                            'nama' => $siswa->nama,
                            'kelas' => $siswa->kelas,
                            'ket' => 'Siswa',
                        ]);
                    }
                } elseif (str_starts_with($value, 'asn_')) {
                    $id = (int) str_replace('asn_', '', $value);
                    $asn = Asn::find($id);
                    if ($asn) {
                        $suratDispensasi->pesertaDispensasis()->create([
                            'nama' => $asn->nama,
                            'kelas' => '-',
                            'ket' => 'ASN',
                        ]);
                    }
                }
            }
        }

        return redirect()->route('surat-dispensasis.print', $suratDispensasi)
            ->with('success', 'Surat Dispensasi berhasil disimpan.');
    }

    public function edit(SuratDispensasi $suratDispensasi): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $suratDispensasi->load('penandatangan', 'pesertaDispensasis');

        $selectedPeserta = [];
        foreach ($suratDispensasi->pesertaDispensasis as $peserta) {
            $siswa = DataSiswa::where('nama', $peserta->nama)->first();
            if ($siswa) {
                $selectedPeserta[] = 'siswa_'.$siswa->id;
            } else {
                $asn = Asn::where('nama', $peserta->nama)->first();
                if ($asn) {
                    $selectedPeserta[] = 'asn_'.$asn->id;
                }
            }
        }

        return view('surat_dispensasis.edit', compact('asns', 'siswas', 'suratDispensasi', 'selectedPeserta'));
    }

    public function update(Request $request, SuratDispensasi $suratDispensasi): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:255',
            'nama_kegiatan' => 'nullable|string|max:255',
            'hari_tanggal' => 'nullable|string|max:255',
            'waktu' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'peserta_select' => 'nullable|array',
            'peserta_select.*' => 'string',
        ]);

        $suratDispensasi->update($validated);

        $suratDispensasi->pesertaDispensasis()->delete();

        if (! empty($validated['peserta_select'])) {
            foreach ($validated['peserta_select'] as $value) {
                if (str_starts_with($value, 'siswa_')) {
                    $id = (int) str_replace('siswa_', '', $value);
                    $siswa = DataSiswa::find($id);
                    if ($siswa) {
                        $suratDispensasi->pesertaDispensasis()->create([
                            'nama' => $siswa->nama,
                            'kelas' => $siswa->kelas,
                            'ket' => 'Siswa',
                        ]);
                    }
                } elseif (str_starts_with($value, 'asn_')) {
                    $id = (int) str_replace('asn_', '', $value);
                    $asn = Asn::find($id);
                    if ($asn) {
                        $suratDispensasi->pesertaDispensasis()->create([
                            'nama' => $asn->nama,
                            'kelas' => '-',
                            'ket' => 'ASN',
                        ]);
                    }
                }
            }
        }

        return redirect()->route('surat-dispensasis.print', $suratDispensasi)
            ->with('success', 'Surat Dispensasi berhasil diperbarui.');
    }

    public function destroy(SuratDispensasi $suratDispensasi): RedirectResponse
    {
        $suratDispensasi->delete();

        return redirect()->route('surat-dispensasis.index')->with('success', 'Surat Dispensasi berhasil dihapus.');
    }

    public function print(SuratDispensasi $suratDispensasi): View
    {
        $suratDispensasi->load('penandatangan', 'pesertaDispensasis');

        $kopSuratBase64 = null;
        $logo = LogoSetting::where('name', 'kop_smk')->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_dispensasis.print', compact('suratDispensasi', 'kopSuratBase64'));
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
