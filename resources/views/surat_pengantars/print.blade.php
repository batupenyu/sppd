<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar Dinas</title>
    <style>
        @page {
            size: A4;
            margin: 0;
            margin-top: 0cm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 15mm 20mm 15mm;
            margin: 0 auto;
            background: white;
            box-sizing: border-box;
        }
        .kop-surat-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat-image {
            max-width: 100%;
            height: auto;
            max-height: 220px;
            object-fit: contain;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px solid #000;
            margin-bottom: 25px;
        }
        .kop-logo {
            width: 15%;
            text-align: left;
            vertical-align: middle;
            padding-bottom: 10px;
        }
        .kop-logo img {
            width: 70px;
            height: auto;
        }
        .kop-teks {
            width: 85%;
            text-align: center;
            vertical-align: middle;
            padding-bottom: 10px;
        }
        .kop-pemprov {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-perangkat {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .kop-alamat {
            font-size: 10pt;
            margin-top: 4px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .tujuan-box {
            margin-top: 15px;
            line-height: 1.3;
        }

        .judul-surat {
            text-align: center;
            font-size: 13pt;
            text-transform: uppercase;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }
        .judul-surat div {
            margin-top: 2px;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }
        .content-table th {
            font-weight: bold;
            text-align: center;
            background-color: #ffffff;
        }
        .content-table th, .content-table td {
            border: 1px solid #000;
            padding: 8px 10px;
            vertical-align: top;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .ttd-box {
            width: 50%;
            vertical-align: top;
        }
        .ttd-space {
            height: 80px;
        }
        .ttd-dots {
            border-bottom: 1px dotted #000;
            height: 60px;
            margin-bottom: 5px;
        }
        
        .footer-phone {
            margin-top: 40px;
            font-size: 11pt;
        }

        .no-print {
            margin-top: 20px;
            text-align: center;
        }

        @media print {
            body { background: white; }
            .page { 
                margin: 0; 
                box-shadow: none;
                width: 100%;
                height: auto;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="page">

    <div class="kop-surat-container">
        @if($kopSuratBase64)
            <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
        @endif
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: right;">
                {{ $suratPengantar->tempat_ditetapkan }}, {{ \App\Http\Controllers\SuratPengantarController::formatTanggal($suratPengantar->tanggal_ditetapkan, '%d %B %Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tujuan-box">
                Yth. {{ $suratPengantar->tujuan_surat }}<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
            </td>
        </tr>
    </table>

    <div class="judul-surat">
        SURAT PENGANTAR
        <div>NOMOR: {{ $suratPengantar->nomor_surat }}</div>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 8%;">No.</th>
                <th style="width: 50%;">Naskah Dinas/Barang yang Dikirimkan</th>
                <th style="width: 17%;">Banyaknya</th>
                <th style="width: 25%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1</td>
                <td style="text-align: justify;">{{ $suratPengantar->isi_surat ?: '&nbsp;' }}</td>
                <td style="text-align: justify;">{{ $suratPengantar->banyaknya ?: '1 (satu) berkas' }}</td>
                <td>{{ $suratPengantar->keterangan ?: 'Demikian disampaikan untuk dapat ditindaklanjuti' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="ttd-table">
        <tr>
            <td class="ttd-box">
                Diterima tanggal ....................<br>
                Penerima<br>
                .....................................,<br>
                <div class="ttd-space"></div>
                <u>.....................................,</u><br>
                .....................................<br>
                NIP...............................
            </td>
            <td class="ttd-box" style="padding-left: 70px;">
                <br>
                Pengirim<br>
                {{ $suratPengantar->penandatangan->jabatan ?? '' }},<br>
                <div class="ttd-space"></div>
                <u>{{ $suratPengantar->penandatangan->nama ?? '' }}</u><br>
                {{ $suratPengantar->penandatangan->pangkat ?? '' }}/{{ $suratPengantar->penandatangan->golongan ?? '' }}<br>
                NIP. {{ $suratPengantar->penandatangan->nip ?? '' }}
            </td>
        </tr>
    </table>

    @if($suratPengantar->nomor_telepon)
    <div class="footer-phone">
        Nomor telepon {{ $suratPengantar->nomor_telepon }}
    </div>
    @endif

    <div class="no-print">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('surat-pengantars.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>

    </div>

</body>
</html>
