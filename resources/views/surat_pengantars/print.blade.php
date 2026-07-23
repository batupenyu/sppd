<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar - {{ $suratPengantar->nomor_surat }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 1cm;
        }
        body {
                    background-color: #525659;
            font-family: "Helvetica", sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }
        .printable-page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 18mm;
            margin: 20px auto;
            background: white;
            position: relative;
            box-shadow: 0 0 6px rgba(0,0,0,0.3);
        }
        .info-surat {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-surat td {
            vertical-align: top;
            padding: 2px 0;
        }
        .titik-titik {
            border-bottom: 1px dotted #000;
            display: inline-block;
        }
        .judul-surat {
            text-align: center;
            margin-bottom: 20px;
            page-break-after: avoid;
        }
        .judul-surat h3 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 5px 0;
        }
        .judul-surat p {
            margin: 0;
            font-size: 11pt;
        }
        .tabel-konten {
            width: 75%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
            page-break-inside: auto;
        }
        .tabel-konten thead {
            display: table-header-group;
        }
        .tabel-konten th,
        .tabel-konten td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
            font-size: 11pt;
        }
        .tabel-konten .text-justify {
            text-align: justify;
        }
        .tabel-konten th {
            font-weight: bold;
            text-align: center;
            background-color: #ffffff;
        }
        .tanda-tangan-container {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .tanda-tangan-container td {
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }
        .ttd-box {
            text-align: left;
            font-size: 11pt;
        }
        .space-ttd {
            height: 70px;
        }
        .footer-telepon {
            margin-top: 20px;
            font-size: 11pt;
        }
        .no-print {
            margin-top: 20px;
            text-align: center;
        }
        @media print {
            body { background: white; }
            .printable-page {
                box-shadow: none;
                margin: 0;
                page-break-after: always;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="printable-page">

    @if($kopSuratBase64)
    <img
        src="{{ $kopSuratBase64 }}"
        style="max-width: 100%; height: auto; display: block; margin-bottom: 15px"
    />
    @endif

    <!-- TANGGAL & TUJUAN -->
    <table class="info-surat">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: right;">
                {{ $suratPengantar->tempat_ditetapkan }}, {{ \App\Http\Controllers\SuratPengantarController::formatTanggal($suratPengantar->tanggal_ditetapkan, '%d %B %Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 15px;">
                Yth. <span style="min-width: 350px;">{{ $suratPengantar->yth ?: '' }}</span><br>
                <!-- <span style="min-width: 380px; margin-top: 5px; display: inline-block;">{{ $suratPengantar->tujuan_surat ?: '' }}</span><br> -->
                <span style="display: inline-block; margin-top: 5px; margin-left: 30px;">di</span><br>
                <span style="min-width: 350px; margin-left: 30px; margin-top: 5px; display: inline-block;">{{ $suratPengantar->di ?: '' }}</span>
            </td>
        </tr>
    </table>

    <!-- JUDUL SURAT -->
    <div class="judul-surat">
        <h3>Surat Pengantar</h3>
        <p>NOMOR : <span style="min-width: 150px;"></span> {{ $suratPengantar->nomor_surat }}</p>
    </div>

    <!-- TABEL UTAMA -->
    <table class="tabel-konten">
        <thead>
            <tr>
                <th style="width: 8%;">No.</th>
                <th class="text-left" style="width: 52%;">Naskah Dinas/Barang<br>yang Dikirimkan</th>
                <th style="width: 15%;">Banyaknya</th>
                <th class="text-left" style="width: 25%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td style="text-align: center;height: 200px">1.</td>
                    <td class="text-justify">{{ $suratPengantar->isi_surat ?: '&nbsp;' }}</td>
                    <td>{{ $suratPengantar->banyaknya ?: '1 (satu) berkas' }}</td>
                    <td class="text-left">{{ $suratPengantar->keterangan ?: 'Demikian disampaikan untuk dapat ditindaklanjuti' }}</td>
                </tr>
        </tbody>
    </table>

    <!-- TANDA TANGAN (PENERIMA & PENGIRIM) -->
    <table class="tanda-tangan-container">
        <tr>
            <td style="padding-left: 40px;">
                <div class="ttd-box">
                    Diterima tanggal <span class="titik-titik" style="min-width: 120px;"></span><br>
                    <!-- <span class="titik-titik" style="min-width: 120px;"></span><br> -->
                    <!-- <span class="titik-titik" style="min-width: 120px;"></span><br> -->
                    <!-- Nama Jabatan,<br> -->
                    <div class="space-ttd"></div> <br> <br>
                    <!-- <strong><u>Nama</u></strong><br>
                    Pangkat/Golongan<br> -->
                    Nama. <span class="titik-titik" style="min-width: 120px;"></span> <br>
                    NIP. <span class="titik-titik" style="min-width: 120px;"></span>
                </div>
            </td>
            <td style="padding-left: 50px;">
                <div class="ttd-box">
                    <br>
                    Pengirim<br>
                    {{ $suratPengantar->penandatangan->jabatan ?? '' }},<br>
                    <div class="space-ttd"></div>
                    <strong><u>{{ $suratPengantar->penandatangan->nama ?? '' }}</u></strong><br>
                    {{ $suratPengantar->penandatangan->pangkat ?? '' }}, {{ $suratPengantar->penandatangan->golongan ?? '' }}<br>
                    NIP. {{ $suratPengantar->penandatangan->nip ?? '' }}
                </div>
            </td>
        </tr>
    </table>

    <!-- FOOTER NOMOR TELEPON -->
    @if($suratPengantar->nomor_telepon)
    <div class="footer-telepon" style="padding-left:40px;">
        Nomor telepon <span class="titik-titik" style="min-width: 150px;"></span> {{ $suratPengantar->nomor_telepon }}
    </div>
    @endif

</div>

<div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-pengantars.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>

</body>
</html>
