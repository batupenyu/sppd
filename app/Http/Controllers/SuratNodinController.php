<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use App\Models\DataSiswa;
use App\Models\LogoSetting;
use App\Models\PhotoNodin;
use App\Models\SuratNodin;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratNodinController extends Controller
{
    public function index(): View
    {
        $suratNodins = SuratNodin::with(['penandatangan'])
            ->latest()
            ->paginate(10);

        return view('surat_nodins.index', compact('suratNodins'));
    }

    public function create(): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $logos = \App\Models\LogoSetting::orderBy('name')->get();

        return view('surat_nodins.create', compact('asns', 'siswas', 'logos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratNodin = SuratNodin::create($validated);
        $this->syncPeserta($suratNodin, $request);

        return redirect()->route('surat-nodins.print', $suratNodin)
            ->with('success', 'Surat Nodin berhasil disimpan.');
    }

    public function edit(SuratNodin $suratNodin): View
    {
        $asns = Asn::orderBy('nama')->get();
        $siswas = DataSiswa::orderBy('nama')->get();
        $logos = \App\Models\LogoSetting::orderBy('name')->get();
        $suratNodin->load('penandatangan', 'pesertaSuratUsulans');

        return view('surat_nodins.edit', compact('asns', 'siswas', 'logos', 'suratNodin'));
    }

    public function update(Request $request, SuratNodin $suratNodin): RedirectResponse
    {
        $validated = $this->validateData($request);

        $suratNodin->update($validated);
        $suratNodin->pesertaSuratUsulans()->delete();
        $this->syncPeserta($suratNodin, $request);

        return redirect()->route('surat-nodins.print', $suratNodin)
            ->with('success', 'Surat Nodin berhasil diperbarui.');
    }

    public function destroy(SuratNodin $suratNodin): RedirectResponse
    {
        $suratNodin->delete();

        return redirect()->route('surat-nodins.index')
            ->with('success', 'Surat Nodin berhasil dihapus.');
    }

    public function print(SuratNodin $suratNodin): View
    {
        $suratNodin->load('penandatangan', 'pesertaSuratUsulans.pegawai', 'pesertaSuratUsulans.siswa');

        $kopSuratBase64 = null;
        $logoName = $suratNodin->kop_surat ?: 'kop_smk';
        $logo = LogoSetting::where('name', $logoName)->first() ?? LogoSetting::latest()->first();
        if ($logo && $logo->image) {
            $kopSuratBase64 = 'data:'.($logo->mime ?: 'image/png').';base64,'.base64_encode($logo->image);
        }

        return view('surat_nodins.print', compact('suratNodin', 'kopSuratBase64'));
    }

    public function lampiran(SuratNodin $suratNodin): View
    {
        $suratNodin->load('penandatangan', 'pesertaSuratUsulans.pegawai', 'pesertaSuratUsulans.siswa');

        return view('surat_nodins.lampiran', compact('suratNodin'));
    }

    public function photoLampiran(SuratNodin $suratNodin): View
    {
        $suratNodin->load('penandatangan', 'photos');

        return view('surat_nodins.photo_lampiran', compact('suratNodin'));
    }

    public function photos(SuratNodin $suratNodin): View
    {
        $suratNodin->load('photos');

        return view('surat_nodins.photos', compact('suratNodin'));
    }

    public function storePhoto(Request $request, SuratNodin $suratNodin): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            PhotoNodin::create([
                'surat_nodin_id' => $suratNodin->id,
                'caption' => $request->input('caption'),
                'mime' => $file->getClientMimeType(),
                'image' => file_get_contents($file->getRealPath()),
            ]);
        }

        return redirect()->route('surat-nodins.photos', $suratNodin)
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    public function editPhoto(SuratNodin $suratNodin, PhotoNodin $photo): View
    {
        $suratNodin->load('photos');

        return view('surat_nodins.photos_edit', compact('suratNodin', 'photo'));
    }

    public function updatePhoto(Request $request, SuratNodin $suratNodin, PhotoNodin $photo): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        $photo->surat_nodin_id = $suratNodin->id;
        $photo->caption = $request->input('caption');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photo->mime = $file->getClientMimeType();
            $photo->image = file_get_contents($file->getRealPath());
        }

        $photo->save();

        return redirect()->route('surat-nodins.photos', $suratNodin)
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroyPhoto(Request $request, SuratNodin $suratNodin, PhotoNodin $photo): RedirectResponse
    {
        $photo->delete();

        return redirect()->route('surat-nodins.photos', $suratNodin)
            ->with('success', 'Foto berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nomor' => 'nullable|string|max:255',
            'sifat' => 'nullable|string|max:255',
            'lampiran' => 'nullable|string|max:255',
            'hal' => 'nullable|string|max:255',
            'kepada' => 'nullable|string|max:255',
            'dari' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'dasar_surat' => 'nullable|string',
            'isi_surat' => 'nullable|string',
            'penandatangan_id' => 'nullable|exists:asns,id',
            'tempat_ditetapkan' => 'nullable|string|max:255',
            'tanggal_ditetapkan' => 'nullable|date',
            'kop_surat' => 'nullable|string|max:255',
            'peserta' => 'nullable|array',
            'peserta.*.pegawai_id' => 'nullable|exists:asns,id',
            'peserta.*.siswa_id' => 'nullable|exists:data_siswa,id',
            'peserta.*.tanggal_kegiatan' => 'nullable|date',
            'peserta.*.tempat_kegiatan' => 'nullable|string|max:255',
        ]);
    }

    private function syncPeserta(SuratNodin $suratNodin, Request $request): void
    {
        $suratNodin->pesertaSuratUsulans()->delete();

        $peserta = $request->input('peserta', []);
        if (!is_array($peserta)) {
            return;
        }

        foreach ($peserta as $item) {
            if (empty($item['pegawai_id']) && empty($item['siswa_id'])) {
                continue;
            }

            $suratNodin->pesertaSuratUsulans()->create([
                'pegawai_id' => $item['pegawai_id'] ?: null,
                'siswa_id' => $item['siswa_id'] ?: null,
                'tanggal_kegiatan' => $item['tanggal_kegiatan'] ?: null,
                'tempat_kegiatan' => $item['tempat_kegiatan'] ?: null,
            ]);
        }
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
