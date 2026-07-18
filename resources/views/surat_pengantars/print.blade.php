<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar Dinas</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 1.5cm 0.5cm 1.5cm;
        }
        body {
            font-family: "Helvetica", sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
        }
        td.label {
            width: 150px;
            white-space: nowrap;
        }
        td.value {
            white-space: nowrap;
        }
        td.colon {
            width: 15px;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
        .footer-phone {
            font-size: 11pt;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 18mm;
            margin: 20px auto;
            background: white;
            position: relative;
            box-shadow: 0 0 6px rgba(0,0,0,0.3);
        }
        .no-print {
            margin-top: 20px;
            text-align: center;
        }
        @media print {
            body { background: white; }
            .page {
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

    <div class="page">

    @if($kopSuratBase64)
    <img
        src="{{ $kopSuratBase64 }}"
        style="max-width: 100%; height: auto; display: block; margin-bottom: 20px"
    />
    @endif

    <div class="header" style="text-align: center">
        <p>
            <strong>SURAT PENGANTAR</strong><br />
            <strong>Nomor : {{ $suratPengantar->nomor_surat }}</strong>
        </p>
    </div>
    <br />
    <div class="content">
        <table>
            <tr>
                <td class="label">Tempat, Tanggal</td>
                <td class="colon">:</td>
                <td>{{ $suratPengantar->tempat_ditetapkan }}, {{ \App\Http\Controllers\SuratPengantarController::formatTanggal($suratPengantar->tanggal_ditetapkan, '%d %B %Y') }}</td>
            </tr>
            <tr>
                <td class="label">Kepada</td>
                <td class="colon">:</td>
                <td>
                    Yth. {{ $suratPengantar->tujuan_surat }}<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di -<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
                </td>
            </tr>
            <tr>
                <td class="label">Pengirim</td>
                <td class="colon">:</td>
                <td>{{ $suratPengantar->penandatangan->nama ?? '' }}</td>
            </tr>
        </table>
        <br />
        <p style="text-align: justify">
            Dengan ini kami sampaikan naskah dinas/barang sebagaimana terlampir
            berikut ini:
        </p>
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
    </div>
    <br />
    <div class="signature" style="padding-left: 250pt">
        <p>
            {{ $suratPengantar->tempat_ditetapkan }}, {{ \App\Http\Controllers\SuratPengantarController::formatTanggal($suratPengantar->tanggal_ditetapkan, '%d %B %Y') }} <br />
            {{ $suratPengantar->penandatangan->jabatan ?? '' }},
        </p>
        <br />
        <br />
        <br />
        <p>
            {{ $suratPengantar->penandatangan->nama ?? '' }} <br />
            {{ $suratPengantar->penandatangan->pangkat ?? '' }}, {{ $suratPengantar->penandatangan->golongan ?? '' }}
            <br />
            NIP. {{ $suratPengantar->penandatangan->nip ?? '' }}
        </p>
    </div>

    @if($suratPengantar->nomor_telepon)
    <div class="footer-phone" style="margin-top: 30px; font-size: 11pt;">
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
