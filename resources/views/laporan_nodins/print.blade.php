<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nota Dinas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 50px 60px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .kop-surat-image {
            width: 100%;
            max-height: 160px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        .header {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        .header .kop {
            font-size: 14px;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .header .title {
            font-size: 20px;
            text-decoration: underline;
            letter-spacing: 2px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .meta-table td.label {
            width: 120px;
        }
        .meta-table td.colon {
            width: 20px;
            text-align: center;
        }
        .line {
            border-top: 2px solid #000000;
            margin-bottom: 30px;
        }
        .content {
            text-align: justify;
            margin-bottom: 30px;
        }
        .section-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .section-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .section-table td.num {
            width: 40px;
        }
        .section-table td.sub-label {
            width: 120px;
        }
        .section-table td.colon {
            width: 20px;
            text-align: center;
        }
        .nested-list {
            margin: 0;
            padding-left: 20px;
        }
        .nested-list li {
            margin-bottom: 10px;
        }
        .footer-section {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }
        .footer-section td {
            width: 50%;
            vertical-align: top;
        }
        .signature-space {
            height: 100px;
        }
        .name-title {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        @if($kopSuratBase64)
        <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image" />
        @endif
        <div class="title">NOTA DINAS</div>
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">Kepada</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->kepada ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Dari</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->dari ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nomor</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->nomor ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Lampiran</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->lampiran ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td><strong>{{ $laporanNodin->tanggal ? \App\Http\Controllers\LaporanNodinController::formatTanggal($laporanNodin->tanggal, '%A, %d %B %Y') : '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Perihal</td>
            <td class="colon">:</td>
            <td><strong>{{ $laporanNodin->perihal ?: '-' }}</strong></td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="content">
        <p>Dengan Hormat, Bersama ini kami sampaikan perihal laporan hasil Perjalanan Dinas mengikuti kegiatan sebagaimana berikut :</p>
    </div>

    <table class="section-table">
        <tr>
            <td class="num">I.</td>
            <td class="sub-label">Dasar Pelaksanaan</td>
            <td class="colon">:</td>
            <td>{{ $laporanNodin->dasar_pelaksanaan ?: '-' }}</td>
        </tr>
        <tr>
            <td class="num">II.</td>
            <td class="sub-label">Tujuan</td>
            <td class="colon">:</td>
            <td><strong>{{ $laporanNodin->tujuan ?: '-' }}</strong></td>
        </tr>
        <!-- Peserta 1 -->
        <tr>
            <td class="num">III.</td>
            <td class="sub-label">Peserta</td>
            <td class="colon">:</td>
            <td>
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="width:80px; padding:2px 0;">1. Nama</td>
                        <td style="width:20px; text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->peserta1_nama ?: '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:2px 0;">&nbsp;&nbsp;&nbsp;NIP</td>
                        <td style="text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->peserta1_nip ?: '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:2px 0;">&nbsp;&nbsp;&nbsp;Jabatan</td>
                        <td style="text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->peserta1_jabatan ?: '' }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Peserta 2 -->
        <tr>
            <td class="num"></td>
            <td class="sub-label"></td>
            <td class="colon"></td>
            <td style="padding-top:10px;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="width:80px; padding:2px 0;">2. Nama</td>
                        <td style="width:20px; text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->peserta2_nama ?: '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:2px 0;">&nbsp;&nbsp;&nbsp;NIP</td>
                        <td style="text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->peserta2_nip ?: '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:2px 0;">&nbsp;&nbsp;&nbsp;Jabatan</td>
                        <td style="text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->peserta2_jabatan ?: '' }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Pelaksanaan -->
        <tr>
            <td class="num">IV.</td>
            <td class="sub-label">Pelaksanaan</td>
            <td class="colon">:</td>
            <td>
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="width:80px; padding:2px 0;">Tanggal</td>
                        <td style="width:20px; text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->pelaksanaan_tanggal ? \App\Http\Controllers\LaporanNodinController::formatTanggal($laporanNodin->pelaksanaan_tanggal, '%A, %d %B %Y') : '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:2px 0;">Jam</td>
                        <td style="text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->pelaksanaan_jam ?: '' }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding:2px 0;">Tempat</td>
                        <td style="text-align:center;">:</td>
                        <td><strong>{{ $laporanNodin->pelaksanaan_tempat ?: '' }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Kesimpulan -->
        <tr>
            <td class="num">V.</td>
            <td class="sub-label">Kesimpulan</td>
            <td class="colon">:</td>
            <td>
                <ol class="nested-list">
                    @foreach(explode("\n", $laporanNodin->kesimpulan ?: '') as $item)
                        @if(trim($item) !== '')
                            <li>{{ trim($item) }}</li>
                        @endif
                    @endforeach
                    @if(!(($laporanNodin->kesimpulan ?? '') !== ''))
                        <li>{{ $laporanNodin->kesimpulan ?: '-' }}</li>
                    @endif
                </ol>
            </td>
        </tr>
    </table>

    <div class="content" style="margin-top:30px;">
        <p>Demikian disampaikan, atas perkenan bapak diucapkan terima kasih.</p>
    </div>

    <table class="footer-section">
        <tr>
            <td>
                <strong>Mengetahui</strong><br>
                <strong>Kepala Sekolah</strong>
                <div class="signature-space"></div>
                <span class="name-title">{{ $laporanNodin->penandatangan->nama ?? '' }}</span><br>
                NIP. {{ $laporanNodin->penandatangan->nip ?? '' }}
            </td>
            <td>
                Yang Melaksanakan Tugas,<br>
                <br>
                1. <strong>{{ $laporanNodin->peserta1_nama ?: '' }}</strong><br>
                &nbsp;&nbsp;&nbsp;&nbsp;NIP. {{ $laporanNodin->peserta1_nip ?: '' }}<br>
                &nbsp;&nbsp;&nbsp;&nbsp;{{ $laporanNodin->peserta1_jabatan ?: '' }}<br>
                <br>
                2. {{ $laporanNodin->peserta2_nama ? 'Nama : ' . $laporanNodin->peserta2_nama : 'Nama :' }}<br>
                &nbsp;&nbsp;&nbsp;&nbsp;NIP : {{ $laporanNodin->peserta2_nip ?: '' }}<br>
                &nbsp;&nbsp;&nbsp;&nbsp;Jabatan : {{ $laporanNodin->peserta2_jabatan ?: '' }}
            </td>
        </tr>
    </table>
</div>

<div class="no-print" style="text-align:center; margin-top:20px;">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('laporan-nodins.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>

</body>
</html>
