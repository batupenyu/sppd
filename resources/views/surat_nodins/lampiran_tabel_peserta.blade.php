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
            font-size: 8.5pt;
        }
        @page {
            size: A4 portrait;
            margin: 1cm 1cm 1cm 1cm;
        }
        .header-info {
            margin-bottom: 20px;
            line-height: 1.0;
            padding-left: 300px;
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
            font-size: 10px;
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
            padding: 6px 8px;
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
        /* Style untuk list bullet pada tempat kegiatan */
        .kegiatan-list {
            margin: 0;
            padding-left: 15px;
        }
        .kegiatan-list li {
            margin-bottom: 6px;
        }
        .kegiatan-list li:last-child {
            margin-bottom: 0;
        }
        .signature-container {
            margin-top: 10px;
            float: right;
            width: 50%;
            text-align: left;
            font-size: 10pt;
            page-break-inside: avoid;
            page-break-after: avoid;
        }
        .signature-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 10pt;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
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
                <th style="width: 25%;">Tanggal / Tempat <br> Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $pesertaList = $suratNodin->pesertaSuratUsulans;

                // Pastikan data peserta unik (tidak ada duplikasi baris peserta)
                $uniquePeserta = $pesertaList->unique(function ($p) {
                    return $p->pegawai_id ?? $p->siswa_id ?? $p->id;
                })->values();

                $totalRowspan = $uniquePeserta->count();

                // Ambil daftar unik tempat/kegiatan diformat dalam bentuk array teks bersih tanpa tanda minus
                $uniqueKegiatan = $pesertaList->map(function($p) {
                    $awal = ($p->tgl_awal_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? \Carbon\Carbon::parse($p->tgl_awal_kegiatan->format('Y-m-d')) : null;
                    $akhir = ($p->tgl_akhir_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? \Carbon\Carbon::parse($p->tgl_akhir_kegiatan->format('Y-m-d')) : null;
                    $tempat = $p->tempat_kegiatan ?? '';

                    if ($awal && $akhir && $awal->isSameDay($akhir)) {
                        $tglText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y');
                    } elseif ($awal && $akhir && $awal->format('n') === $akhir->format('n') && $awal->format('Y') === $akhir->format('Y')) {
                        $tglText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d') . ' s.d. ' . \App\Http\Controllers\SuratNodinController::formatTanggal($akhir, '%d %B %Y');
                    } elseif ($awal && $akhir) {
                        $tglText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y') . ' s.d. ' . \App\Http\Controllers\SuratNodinController::formatTanggal($akhir, '%d %B %Y');
                    } elseif ($awal) {
                        $tglText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y');
                    } else {
                        $tglText = '';
                    }

                    if ($tglText && $tempat) {
                        return $tglText . '<br>' . $tempat;
                    } elseif ($tglText) {
                        return $tglText;
                    } else {
                        return $tempat;
                    }
                })->filter(function($val) {
                    return !empty(trim(strip_tags($val)));
                })->unique();
            @endphp

            @forelse($uniquePeserta as $index => $peserta)
                @php
                    $no = $index + 1;
                @endphp
                <tr>
                    <td class="text-center">{{ $no }}</td>
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

                    {{-- Kolom Tempat Kegiatan di-rowspan menggunakan tag <ul> <li> (bullet) tanpa tanda "-" --}}
                    @if($index == 0)
                        <td rowspan="{{ $totalRowspan }}">
                            <ul class="kegiatan-list">
                                @foreach($uniqueKegiatan as $kegiatan)
                                    <li>{!! $kegiatan !!}</li>
                                @endforeach
                            </ul>
                        </td>
                    @endif
                </tr>
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

    <div class="no-print">
        <a href="{{ route('surat-nodins.print', $suratNodin) }}" style="display:inline-block; margin-right:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    </div>
</body>
</html>