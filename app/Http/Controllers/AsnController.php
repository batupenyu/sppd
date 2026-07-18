<?php

namespace App\Http\Controllers;

use App\Models\Asn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AsnController extends Controller
{
    public function index()
    {
        $asns = Asn::latest()->paginate(10);
        return view('asns.index', compact('asns'));
    }

    public function create()
    {
        return view('asns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'nuptk' => 'nullable|string|max:50',
            'jk' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nip' => 'nullable|string|max:50',
            'status_kepegawaian' => 'nullable|string|max:255',
            'jenis_ptk' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'alamat_jalan' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'nama_dusun' => 'nullable|string|max:255',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tugas_tambahan' => 'nullable|string',
            'sk_cpns' => 'nullable|string|max:255',
            'tanggal_cpns' => 'nullable|date',
            'sk_pengangkatan' => 'nullable|string|max:255',
            'tmt_pengangkatan' => 'nullable|date',
            'lembaga_pengangkatan' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'pangkat_golongan' => 'nullable|string|max:255',
            'sumber_gaji' => 'nullable|string|max:255',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'nama_suami_istri' => 'nullable|string|max:255',
            'nip_suami_istri' => 'nullable|string|max:50',
            'pekerjaan_suami_istri' => 'nullable|string|max:255',
            'tmt_pns' => 'nullable|date',
            'sudah_lisensi_kepala_sekolah' => 'nullable|in:Ya,Tidak',
            'pernah_diklat_kepengawasan' => 'nullable|in:Ya,Tidak',
            'keahlian_braille' => 'nullable|in:Ya,Tidak',
            'keahlian_bahasa_isyarat' => 'nullable|in:Ya,Tidak',
            'npwp' => 'nullable|string|max:20',
            'nama_wajib_pajak' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'bank' => 'nullable|string|max:255',
            'nomor_rekening_bank' => 'nullable|string|max:50',
            'rekening_atas_nama' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'no_kk' => 'nullable|string|max:20',
            'karpeg' => 'nullable|string|max:255',
            'karis_karsu' => 'nullable|string|max:255',
            'lintang' => 'nullable|string|max:50',
            'bujur' => 'nullable|string|max:50',
            'nuks' => 'nullable|string|max:50',
        ]);

        Asn::create($validated);

        return redirect()->route('asns.index')->with('success', 'Data ASN berhasil ditambahkan.');
    }

    public function show(Asn $asn)
    {
        return view('asns.show', compact('asn'));
    }

    public function edit(Asn $asn)
    {
        return view('asns.edit', compact('asn'));
    }

    public function update(Request $request, Asn $asn)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'nuptk' => 'nullable|string|max:50',
            'jk' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nip' => 'nullable|string|max:50',
            'status_kepegawaian' => 'nullable|string|max:255',
            'jenis_ptk' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'alamat_jalan' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'nama_dusun' => 'nullable|string|max:255',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tugas_tambahan' => 'nullable|string',
            'sk_cpns' => 'nullable|string|max:255',
            'tanggal_cpns' => 'nullable|date',
            'sk_pengangkatan' => 'nullable|string|max:255',
            'tmt_pengangkatan' => 'nullable|date',
            'lembaga_pengangkatan' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'pangkat_golongan' => 'nullable|string|max:255',
            'sumber_gaji' => 'nullable|string|max:255',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'nama_suami_istri' => 'nullable|string|max:255',
            'nip_suami_istri' => 'nullable|string|max:50',
            'pekerjaan_suami_istri' => 'nullable|string|max:255',
            'tmt_pns' => 'nullable|date',
            'sudah_lisensi_kepala_sekolah' => 'nullable|in:Ya,Tidak',
            'pernah_diklat_kepengawasan' => 'nullable|in:Ya,Tidak',
            'keahlian_braille' => 'nullable|in:Ya,Tidak',
            'keahlian_bahasa_isyarat' => 'nullable|in:Ya,Tidak',
            'npwp' => 'nullable|string|max:20',
            'nama_wajib_pajak' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'bank' => 'nullable|string|max:255',
            'nomor_rekening_bank' => 'nullable|string|max:50',
            'rekening_atas_nama' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'no_kk' => 'nullable|string|max:20',
            'karpeg' => 'nullable|string|max:255',
            'karis_karsu' => 'nullable|string|max:255',
            'lintang' => 'nullable|string|max:50',
            'bujur' => 'nullable|string|max:50',
            'nuks' => 'nullable|string|max:50',
        ]);

        $asn->update($validated);

        return redirect()->route('asns.index')->with('success', 'Data ASN berhasil diperbarui.');
    }

    public function destroy(Asn $asn)
    {
        $asn->delete();

        return redirect()->route('asns.index')->with('success', 'Data ASN berhasil dihapus.');
    }

    public function destroyAll()
    {
        Asn::query()->delete();

        return redirect()->route('asns.index')->with('success', 'Semua data ASN berhasil dihapus.');
    }

    public function export()
    {
        $asns = Asn::all();
        $filename = 'data_asn_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Nama',
            'NUPTK',
            'JK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIP',
            'Status Kepegawaian',
            'Jenis PTK',
            'Agama',
            'Alamat Jalan',
            'RT',
            'RW',
            'Nama Dusun',
            'Desa/Kelurahan',
            'Kecamatan',
            'Kode Pos',
            'Telepon',
            'HP',
            'Email',
            'Tugas Tambahan',
            'SK CPNS',
            'Tanggal CPNS',
            'SK Pengangkatan',
            'TMT Pengangkatan',
            'Lembaga Pengangkatan',
            'Pangkat Golongan',
            'Sumber Gaji',
            'Nama Ibu Kandung',
            'Status Perkawinan',
            'Nama Suami/Istri',
            'NIP Suami/Istri',
            'Pekerjaan Suami/Istri',
            'TMT PNS',
            'Sudah Lisensi Kepala Sekolah',
            'Pernah Diklat Kepengawasan',
            'Keahlian Braille',
            'Keahlian Bahasa Isyarat',
            'NPWP',
            'Nama Wajib Pajak',
            'Kewarganegaraan',
            'Bank',
            'Nomor Rekening Bank',
            'Rekening Atas Nama',
            'NIK',
            'No KK',
            'Karpeg',
            'Karis/Karsu',
            'Lintang',
            'Bujur',
            'NUKS',
        ];

        $callback = function () use ($asns, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($asns as $asn) {
                fputcsv($file, [
                    $asn->nama,
                    $asn->nuptk,
                    $asn->jk,
                    $asn->tempat_lahir,
                    $asn->tanggal_lahir,
                    $asn->nip,
                    $asn->status_kepegawaian,
                    $asn->jenis_ptk,
                    $asn->agama,
                    $asn->alamat_jalan,
                    $asn->rt,
                    $asn->rw,
                    $asn->nama_dusun,
                    $asn->desa_kelurahan,
                    $asn->kecamatan,
                    $asn->kode_pos,
                    $asn->telepon,
                    $asn->hp,
                    $asn->email,
                    $asn->tugas_tambahan,
                    $asn->sk_cpns,
                    $asn->tanggal_cpns,
                    $asn->sk_pengangkatan,
                    $asn->tmt_pengangkatan,
                    $asn->lembaga_pengangkatan,
                    $asn->pangkat_golongan,
                    $asn->sumber_gaji,
                    $asn->nama_ibu_kandung,
                    $asn->status_perkawinan,
                    $asn->nama_suami_istri,
                    $asn->nip_suami_istri,
                    $asn->pekerjaan_suami_istri,
                    $asn->tmt_pns,
                    $asn->sudah_lisensi_kepala_sekolah,
                    $asn->pernah_diklat_kepengawasan,
                    $asn->keahlian_braille,
                    $asn->keahlian_bahasa_isyarat,
                    $asn->npwp,
                    $asn->nama_wajib_pajak,
                    $asn->kewarganegaraan,
                    $asn->bank,
                    $asn->nomor_rekening_bank,
                    $asn->rekening_atas_nama,
                    $asn->nik,
                    $asn->no_kk,
                    $asn->karpeg,
                    $asn->karis_karsu,
                    $asn->lintang,
                    $asn->bujur,
                    $asn->nuks,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportXlsx()
    {
        $asns = Asn::all();
        $filename = 'data_asn_' . date('Y-m-d_H-i-s') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            'Nama',
            'NUPTK',
            'JK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIP',
            'Status Kepegawaian',
            'Jenis PTK',
            'Agama',
            'Alamat Jalan',
            'RT',
            'RW',
            'Nama Dusun',
            'Desa/Kelurahan',
            'Kecamatan',
            'Kode Pos',
            'Telepon',
            'HP',
            'Email',
            'Tugas Tambahan',
            'SK CPNS',
            'Tanggal CPNS',
            'SK Pengangkatan',
            'TMT Pengangkatan',
            'Lembaga Pengangkatan',
            'Pangkat Golongan',
            'Sumber Gaji',
            'Nama Ibu Kandung',
            'Status Perkawinan',
            'Nama Suami/Istri',
            'NIP Suami/Istri',
            'Pekerjaan Suami/Istri',
            'TMT PNS',
            'Sudah Lisensi Kepala Sekolah',
            'Pernah Diklat Kepengawasan',
            'Keahlian Braille',
            'Keahlian Bahasa Isyarat',
            'NPWP',
            'Nama Wajib Pajak',
            'Kewarganegaraan',
            'Bank',
            'Nomor Rekening Bank',
            'Rekening Atas Nama',
            'NIK',
            'No KK',
            'Karpeg',
            'Karis/Karsu',
            'Lintang',
            'Bujur',
            'NUKS',
        ], null, 'A1');

        $row = 2;
        foreach ($asns as $asn) {
            $sheet->fromArray([
                $asn->nama,
                $asn->nuptk,
                $asn->jk,
                $asn->tempat_lahir,
                $asn->tanggal_lahir,
                $asn->nip,
                $asn->status_kepegawaian,
                $asn->jenis_ptk,
                $asn->agama,
                $asn->alamat_jalan,
                $asn->rt,
                $asn->rw,
                $asn->nama_dusun,
                $asn->desa_kelurahan,
                $asn->kecamatan,
                $asn->kode_pos,
                $asn->telepon,
                $asn->hp,
                $asn->email,
                $asn->tugas_tambahan,
                $asn->sk_cpns,
                $asn->tanggal_cpns,
                $asn->sk_pengangkatan,
                $asn->tmt_pengangkatan,
                $asn->lembaga_pengangkatan,
                $asn->pangkat_golongan,
                $asn->sumber_gaji,
                $asn->nama_ibu_kandung,
                $asn->status_perkawinan,
                $asn->nama_suami_istri,
                $asn->nip_suami_istri,
                $asn->pekerjaan_suami_istri,
                $asn->tmt_pns,
                $asn->sudah_lisensi_kepala_sekolah,
                $asn->pernah_diklat_kepengawasan,
                $asn->keahlian_braille,
                $asn->keahlian_bahasa_isyarat,
                $asn->npwp,
                $asn->nama_wajib_pajak,
                $asn->kewarganegaraan,
                $asn->bank,
                $asn->nomor_rekening_bank,
                $asn->rekening_atas_nama,
                $asn->nik,
                $asn->no_kk,
                $asn->karpeg,
                $asn->karis_karsu,
                $asn->lintang,
                $asn->bujur,
                $asn->nuks,
            ], null, 'A' . $row);
            $row++;
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $tempFile = tempnam(sys_get_temp_dir(), 'asn');
        $writer->save($tempFile);

        return Response::download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function import()
    {
        return view('asns.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');
        $headers = fgetcsv($file);

        $headerMap = [
            'nama' => 'nama',
            'nuptk' => 'nuptk',
            'jk' => 'jk',
            'tempat lahir' => 'tempat_lahir',
            'tanggal lahir' => 'tanggal_lahir',
            'nip' => 'nip',
            'status kepegawaian' => 'status_kepegawaian',
            'jenis ptk' => 'jenis_ptk',
            'agama' => 'agama',
            'alamat jalan' => 'alamat_jalan',
            'rt' => 'rt',
            'rw' => 'rw',
            'nama dusun' => 'nama_dusun',
            'desa/kelurahan' => 'desa_kelurahan',
            'desa kelurahan' => 'desa_kelurahan',
            'kecamatan' => 'kecamatan',
            'kode pos' => 'kode_pos',
            'telepon' => 'telepon',
            'hp' => 'hp',
            'email' => 'email',
            'tugas tambahan' => 'tugas_tambahan',
            'sk cpns' => 'sk_cpns',
            'tanggal cpns' => 'tanggal_cpns',
            'sk pengangkatan' => 'sk_pengangkatan',
            'tmt pengangkatan' => 'tmt_pengangkatan',
            'lembaga pengangkatan' => 'lembaga_pengangkatan',
            'pangkat golongan' => 'pangkat_golongan',
            'sumber gaji' => 'sumber_gaji',
            'nama ibu kandung' => 'nama_ibu_kandung',
            'status perkawinan' => 'status_perkawinan',
            'nama suami/istri' => 'nama_suami_istri',
            'nama suami istri' => 'nama_suami_istri',
            'nip suami/istri' => 'nip_suami_istri',
            'nip suami istri' => 'nip_suami_istri',
            'pekerjaan suami/istri' => 'pekerjaan_suami_istri',
            'pekerjaan suami istri' => 'pekerjaan_suami_istri',
            'tmt pns' => 'tmt_pns',
            'sudah lisensi kepala sekolah' => 'sudah_lisensi_kepala_sekolah',
            'pernah diklat kepengawasan' => 'pernah_diklat_kepengawasan',
            'keahlian braille' => 'keahlian_braille',
            'keahlian bahasa isyarat' => 'keahlian_bahasa_isyarat',
            'npwp' => 'npwp',
            'nama wajib pajak' => 'nama_wajib_pajak',
            'kewarganegaraan' => 'kewarganegaraan',
            'bank' => 'bank',
            'nomor rekening bank' => 'nomor_rekening_bank',
            'rekening atas nama' => 'rekening_atas_nama',
            'nik' => 'nik',
            'no kk' => 'no_kk',
            'karpeg' => 'karpeg',
            'karis/karsu' => 'karis_karsu',
            'karis karsu' => 'karis_karsu',
            'lintang' => 'lintang',
            'bujur' => 'bujur',
            'nuks' => 'nuks',
        ];

        $dateFields = [
            'tanggal_lahir',
            'tanggal_cpns',
            'tmt_pengangkatan',
            'tmt_pns',
        ];

        $rowCount = 0;
        $errorRows = [];

        while (($row = fgetcsv($file)) !== false) {
            $data = [];
            foreach ($headers as $index => $header) {
                $key = strtolower(trim($header));
                $field = $headerMap[$key] ?? null;

                if ($field && array_key_exists($index, $row)) {
                    $value = $row[$index];

                    if (in_array($field, ['jk'])) {
                        $value = in_array($value, ['L', 'P']) ? $value : 'L';
                    }

                    if (in_array($field, ['status_perkawinan'])) {
                        $value = in_array($value, ['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati']) ? $value : null;
                    }

                    if (in_array($field, ['sudah_lisensi_kepala_sekolah', 'pernah_diklat_kepengawasan', 'keahlian_braille', 'keahlian_bahasa_isyarat'])) {
                        $value = in_array($value, ['Ya', 'Tidak']) ? $value : null;
                    }

                    if (in_array($field, $dateFields)) {
                        $timestamp = strtotime($value);
                        $value = $timestamp ? date('Y-m-d', $timestamp) : null;
                    }

                    $data[$field] = $value;
                }
            }

            try {
                if (!empty($data)) {
                    Asn::create($data);
                    $rowCount++;
                }
            } catch (\Exception $e) {
                $errorRows[] = 'Baris ' . ($rowCount + 2) . ': ' . $e->getMessage();
            }
        }

        fclose($file);

        $message = "Import selesai. {$rowCount} data berhasil diimport.";
        if (!empty($errorRows)) {
            $message .= '<br>Error:<br>' . implode('<br>', $errorRows);
        }

        return redirect()->route('asns.index')->with('success', $message);
    }
}
