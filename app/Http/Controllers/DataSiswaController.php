<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswas = DataSiswa::latest()->paginate(10);
        return view('data_siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('data_siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:50',
            'nis' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'kelas' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        DataSiswa::create($validated);

        return redirect()->route('data-siswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    public function show(DataSiswa $siswa)
    {
        return view('data_siswa.show', compact('siswa'));
    }

    public function edit(DataSiswa $siswa)
    {
        return view('data_siswa.edit', compact('siswa'));
    }

    public function update(Request $request, DataSiswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:50',
            'nis' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'kelas' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $siswa->update($validated);

        return redirect()->route('data-siswa.index')->with('success', 'Data Siswa berhasil diperbarui.');
    }

    public function destroy(DataSiswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('data-siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
    }

    public function destroyAll()
    {
        DataSiswa::query()->delete();

        return redirect()->route('data-siswa.index')->with('success', 'Semua data siswa berhasil dihapus.');
    }

    public function exportCsv()
    {
        $siswas = DataSiswa::all();
        $filename = 'data_siswa_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Nama',
            'NISN',
            'NIS',
            'Tgl Lahir',
            'Kelas',
            'Alamat',
        ];

        $callback = function () use ($siswas, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($siswas as $siswa) {
                fputcsv($file, [
                    $siswa->nama,
                    $siswa->nisn,
                    $siswa->nis,
                    $siswa->tgl_lahir,
                    $siswa->kelas,
                    $siswa->alamat,
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
        $siswas = DataSiswa::all();
        $filename = 'data_siswa_' . date('Y-m-d_H-i-s') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            'Nama',
            'NISN',
            'NIS',
            'Tgl Lahir',
            'Kelas',
            'Alamat',
        ], null, 'A1');

        $row = 2;
        foreach ($siswas as $siswa) {
            $sheet->fromArray([
                $siswa->nama,
                $siswa->nisn,
                $siswa->nis,
                $siswa->tgl_lahir,
                $siswa->kelas,
                $siswa->alamat,
            ], null, 'A' . $row);
            $row++;
        }

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $tempFile = tempnam(sys_get_temp_dir(), 'siswa');
        $writer->save($tempFile);

        return Response::download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function import()
    {
        return view('data_siswa.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $path = $request->file('file')->getRealPath();

        try {
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Gagal membaca file: ' . $e->getMessage());
        }

        if (empty($rows)) {
            return redirect()->route('data-siswa.index')->with('success', 'File kosong.');
        }

        $headers = array_shift($rows);

        $headerMap = [
            'nama' => 'nama',
            'nisn' => 'nisn',
            'nis' => 'nis',
            'tgl lahir' => 'tgl_lahir',
            'tanggal lahir' => 'tgl_lahir',
            'kelas' => 'kelas',
            'alamat' => 'alamat',
        ];

        $rowCount = 0;
        $errorRows = [];

        foreach ($rows as $r) {
            if (array_filter($r, fn($v) => $v !== null && $v !== '') === []) {
                continue;
            }

            $data = [];
            foreach ($headers as $index => $header) {
                $key = strtolower(trim($header));
                $field = $headerMap[$key] ?? null;

                if ($field && array_key_exists($index, $r)) {
                    $value = $r[$index];

                    if ($field === 'tgl_lahir') {
                        $timestamp = strtotime($value);
                        $value = $timestamp ? date('Y-m-d', $timestamp) : null;
                    }

                    $data[$field] = $value;
                }
            }

            try {
                if (!empty($data['nama'])) {
                    DataSiswa::create($data);
                    $rowCount++;
                }
            } catch (\Exception $e) {
                $errorRows[] = 'Baris ' . ($rowCount + 2) . ': ' . $e->getMessage();
            }
        }

        $message = "Import selesai. {$rowCount} data berhasil diimport.";
        if (!empty($errorRows)) {
            $message .= '<br>Error:<br>' . implode('<br>', $errorRows);
        }

        return redirect()->route('data-siswa.index')->with('success', $message);
    }
}
