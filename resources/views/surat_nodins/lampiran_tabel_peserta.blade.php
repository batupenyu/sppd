<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lampiran Surat Usulan - {{ $suratNodin->hal }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            font-size: 10pt;
        }
        @page {
            size: A4 landscape;
            margin: 1cm 1cm 1cm 1cm;
        }
        .header-info {
            margin-bottom: 20px;
            line-height: 1.0;
            padding-left: 500px;
            font-style: italic;
            page-break-after: avoid;
        }
        .header-info table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .header-info td {
            padding: 2px 0;
            vertical-align: top;
            border: none;
        }
        .header-info .label {
            width: 100px;
            vertical-align: top;
        }
        .header-info .colon {
            width: 10px;
            vertical-align: top;
        }
        .title {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            page-break-after: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            page-break-inside: auto;
        }
        table tr {
            page-break-inside: avoid;
        }
        table thead {
            display: table-header-group;
        }
        table tbody {
            display: table-row-group;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .signature-container {
            margin-top: 10px;
            float: right;
            width: 50%;
            text-align: left;
            font-size: 11pt;
            page-break-inside: avoid;
            page-break-after: avoid;
        }
        .signature-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 11pt;
        }
        .signature-name {
            font-weight: bold;
            font-size: 11pt;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .signature-unit {
            padding-left: 26px;
            display: block;
            font-size: 11pt;
        }
        .signature-body {
            font-weight: bold;
            font-size: 11pt;
        }
        .signature-nip {
            font-weight: bold;
            margin-top: 5px;
            font-size: 11pt;
        }
        .no-print {
            margin-top: 20px;
            text-align: center;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="header-info">
        <table>
            <tr>
                <td class="label">LAMPIRAN I</td>
                <td class="colon">:</td>
                <td>Surat {{ $suratNodin->dari ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">NOMOR</td>
                <td class="colon">:</td>
                <td>{{ $suratNodin->nomor ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">TANGGAL</td>
                <td class="colon">:</td>
                <td>{{ $suratNodin->tanggal ? \App\Http\Controllers\SuratNodinController::formatTanggal($suratNodin->tanggal, '%d %B %Y') : '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="title">
        DAFTAR NAMA {{ strtoupper($suratNodin->hal ?: 'UNDANGAN') }}<br>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 22%;">Nama</th>
                <th style="width: 18%;">NIP/NIS</th>
                <th style="width: 15%;">Pangkat / Gol</th>
                <th style="width: 15%;">Jabatan</th>
                <th style="width: 25%;">Tanggal/Tempat <br> Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $pesertaList = $suratNodin->pesertaSuratUsulans;
                $sorted = $pesertaList->sortBy(function ($p) {
                    $awal = ($p->tgl_awal_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $p->tgl_awal_kegiatan->format('Y-m-d') : ($p->tgl_awal_kegiatan ?? '');
                    $akhir = ($p->tgl_akhir_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $p->tgl_akhir_kegiatan->format('Y-m-d') : ($p->tgl_akhir_kegiatan ?? '');
                    $tempat = $p->tempat_kegiatan ?? '';
                    return $awal . '|' . $akhir . '|' . $tempat;
                })->values();
                $groups = [];
                $current = null;
                foreach ($sorted as $p) {
                    $awal = ($p->tgl_awal_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $p->tgl_awal_kegiatan->format('Y-m-d') : ($p->tgl_awal_kegiatan ?? '');
                    $akhir = ($p->tgl_akhir_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $p->tgl_akhir_kegiatan->format('Y-m-d') : ($p->tgl_akhir_kegiatan ?? '');
                    $tempat = $p->tempat_kegiatan ?? '';
                    $key = $awal . '|' . $akhir . '|' . $tempat;
                    if ($current !== null && $current['key'] === $key) {
                        $current['items'][] = $p;
                    } else {
                        if ($current !== null) { $groups[] = $current; }
                        $current = [
                            'key' => $key,
                            'items' => [$p],
                            'tgl_awal' => $awal,
                            'tgl_akhir' => $akhir,
                            'tempat' => $tempat,
                        ];
                    }
                }
                if ($current !== null) { $groups[] = $current; }
                $no = 0;
            @endphp
            @forelse($groups as $group)
                @php
                    $rowspan = count($group['items']);
                    $awal = $group['tgl_awal'] ? \Carbon\Carbon::parse($group['tgl_awal']) : null;
                    $akhir = $group['tgl_akhir'] ? \Carbon\Carbon::parse($group['tgl_akhir']) : null;
                    $tempat = $group['tempat'] ?: '-';
                    if ($awal && $akhir && $awal->isSameDay($akhir)) {
                        $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y');
                    } elseif ($awal && $akhir && $awal->format('n') === $akhir->format('n') && $awal->format('Y') === $akhir->format('Y')) {
                        $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d') . ' s.d. ' . \App\Http\Controllers\SuratNodinController::formatTanggal($akhir, '%d %B %Y');
                    } elseif ($awal && $akhir) {
                        $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y') . ' s.d. ' . \App\Http\Controllers\SuratNodinController::formatTanggal($akhir, '%d %B %Y');
                    } elseif ($awal) {
                        $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y');
                    } else {
                        $tanggalText = '-';
                    }
                    $tanggalCell = $tanggalText . ' di ' . $tempat;
                @endphp
                @foreach($group['items'] as $itemIndex => $peserta)
                <tr>
                    <td class="text-center">{{ ++$no }}</td>
                    <td>
                        @if($peserta->pegawai)
                            {{ $peserta->pegawai->nama }}
                        @elseif($peserta->siswa)
                            {{ strtoupper($peserta->siswa->nama) }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($peserta->pegawai)
                            {{ $peserta->pegawai->nip ?: '-' }}
                        @elseif($peserta->siswa)
                            {{ $peserta->siswa->nis ?: '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($peserta->pegawai)
                            {{ $peserta->pegawai->pangkat_golongan ?: '-' }}
                        @elseif($peserta->siswa)
                            {{ $peserta->siswa->kelas ?: '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($peserta->pegawai)
                            {{ $peserta->pegawai->jabatan ?: '-' }}
                        @elseif($peserta->siswa)
                            Siswa
                        @else
                            -
                        @endif
                    </td>
                    @if($itemIndex == 0)
                    <td rowspan="{{ $rowspan }}">{{ $tanggalCell }}</td>
                    @endif
                </tr>
                @endforeach
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data peserta.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="clearfix">
        <div class="signature-container">
            <div class="signature-title">
                @php
                    $atasan = $suratNodin->penandatangan;
                    $pegawaiTugas = $suratNodin->pegawaiTugas;

                    $jabatanAtasan = $atasan->jabatan ?? '';
                    $unitKerjaAtasan = $atasan->unit_kerja ?? '';
                    $nama = $atasan->nama ?? '';
                    $pangkat = $atasan->pangkat_golongan ?? '';
                    $golongan = '';
                    $nip = $atasan->nip ?? '';

                    $jabatanTugas = $pegawaiTugas->jabatan ?? '';
                    $unitKerjaTugas = $pegawaiTugas->unit_kerja ?? '';

                    $isPlt = $suratNodin->penandatangan_plt ?? false;
                    $isAn = $suratNodin->penandatangan_an ?? false;

                    if ($isPlt && $isAn) {
                        $isAn = false;
                    }

                    $prefix = '';
                    $indent = false;
                    $showTugas = false;
                    $unitKerja = '';

                    if ($isPlt) {
                        $prefix = 'Plt.' . html_entity_decode('&nbsp;');
                        $indent = true;
                        $showTugas = true;
                        $unitKerja = $unitKerjaTugas ?: $unitKerjaAtasan;
                    } elseif ($isAn) {
                        $prefix = 'a.n.' . html_entity_decode('&nbsp;');
                        $indent = true;
                        $showTugas = true;
                        $unitKerja = $unitKerjaAtasan;
                    } else {
                        $prefix = '';
                        $indent = false;
                        $showTugas = false;
                        $unitKerja = $unitKerjaAtasan;
                    }

                    $indentChar = html_entity_decode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                @endphp
                {{ $prefix . $jabatanAtasan }}
                <br>{{ $indent ? $indentChar . $unitKerja : $unitKerja }}
                <br><br><br>
                @if($showTugas && $jabatanTugas)
                    <br>{{ $indentChar . $jabatanTugas }}
                @endif
                <br>{{ $indent ? $indentChar . $nama : $nama }}
                @if($pangkat && $pangkat != '-')
                    <br>{{ $indent ? $indentChar . $pangkat : $pangkat }}
                @endif
                <br>{{ $indent ? $indentChar . 'NIP. ' . $nip : 'NIP. ' . $nip }}
            </div>
        </div>
      </div>
    </div>

    <div class="no-print">
        <a href="{{ route('surat-nodins.print', $suratNodin) }}" style="display:inline-block; margin-right:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    </div>
</body>
</html>
