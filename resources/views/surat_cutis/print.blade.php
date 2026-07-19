<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Cuti - {{ $suratCuti->nomor_surat ?: 'Tanpa Nomor' }}</title>
    <style>
        @page {
            size: A4;
            margin: 0.5cm 2cm 2cm 2cm;
        }
        body {
                    background-color: #525659;
            font-family: "Helvetica", sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #000;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 0cm;
        }
        .kop-surat {
            width: 100%;
            height: auto;
            margin-bottom: 0cm;
        }
        .right-align {
            text-align: right;
        }
        .left-align {
            text-align: left;
        }
        .justify {
            text-align: justify;
        }
        .indent {
            text-indent: 1cm;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .no-border {
            border: none;
        }
        .valign-top {
            vertical-align: top;
        }
        .signature-block {
            width: 100%;
            margin-top: 1cm;
        }
        .signature-col {
            width: 50%;
            float: left;
            text-align: center;
        }
        .clear-float {
            clear: both;
        }
        .label-col {
            width: 10%;
            white-space: nowrap;
        }
        .colon-col {
            width: 2%;
            text-align: center;
        }
        .value-col {
            width: 65%;
            white-space: nowrap;
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
        .no-print { margin-top: 20px; text-align: center; }
        @media print {
            body { background: white; }
            .page {
                box-shadow: none;
                margin: 0;
                page-break-after: always;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="page container">
        @if ($kopSuratBase64)
        <div class="header">
            <img src="{{ $kopSuratBase64 }}" class="kop-surat" alt="Kop Surat" />
        </div>
        @endif

        <div class="right-align">
            {{ $suratCuti->tempat_ditetapkan ?: '.................' }}, {{ $suratCuti->tanggal_surat ? \App\Http\Controllers\SuratCutiController::formatTanggal($suratCuti->tanggal_surat, '%d %B %Y') : '....................' }}
        </div>
        <br />
        <br />
        <table class="no-border" style="margin-top: 0.5cm">
            <tr>
                <td class="label-col valign-top">Perihal</td>
                <td class="colon-col valign-top">:</td>
                <td class="value-col valign-top">
                    {{ $suratCuti->perihal_surat ?: '.........................' }} {{ $suratCuti->jenis_cuti ?: '' }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 0.5cm">
            <div class="left-align">
                Kepada<br />
                Yth. {{ $suratCuti->tujuan_surat ?: '.........................' }}<br />
                di -<br />
                {{ $suratCuti->tempat_ditetapkan ?: '.........................' }}
            </div>
        </div>

        <br />

        <div style="margin-top: 0.5cm" class="left-align justify indent">
            Yang bertanda tangan dibawah ini :
        </div>

        @php
            $p = $suratCuti->pegawai;
        @endphp
        <table class="no-border" style="margin-top: 0.5cm">
            <tr>
                <td class="label-col valign-top">Nama</td>
                <td class="colon-col valign-top">:</td>
                <td class="value-col valign-top">{{ $p->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col valign-top">NIP</td>
                <td class="colon-col valign-top">:</td>
                <td class="value-col valign-top">{{ $p->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col valign-top">Pangkat/Gol.Ruang</td>
                <td class="colon-col valign-top">:</td>
                <td class="value-col valign-top">
                    {{ $p->pangkat_golongan ?? '-' }}
                </td>
            </tr>
            <tr>
                <td class="label-col valign-top">Jabatan</td>
                <td class="colon-col valign-top">:</td>
                <td class="value-col valign-top">{{ $p->tugas_tambahan ?? ($p->jenis_ptk ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label-col valign-top">Unit Kerja</td>
                <td class="colon-col valign-top">:</td>
                <td class="value-col valign-top">
                    {{ $p->tempat_lahir ?: '-' }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 0.5cm" class="left-align justify indent">
            Dengan ini mengajukan permintaan {{ $suratCuti->jenis_cuti ?: '.........................' }} {{ $leaveDurationText ?: '' }}@if($suratCuti->alasan_cuti), dengan alasan {{ $suratCuti->alasan_cuti }}@endif.
        </div>

        <div style="margin-top: 0.5cm" class="left-align justify indent">
            Demikian permohonan ini disampaikan untuk dapat dipertimbangkan, atas
            perhatian Bapak diucapkan terima kasih.
        </div>

        <div class="signature-block">
            @php
                $penandatangan = $suratCuti->penandatangan;
            @endphp
            @if ($penandatangan)
            <div class="signature-col">
                <p>
                    Mengetahui,<br />
                    {{ $penandatangan->tugas_tambahan ?? ($penandatangan->jenis_ptk ?? '') }}
                </p>
                <br /><br /><br />
                <p>
                    <u>{{ $penandatangan->nama }}</u><br />
                    {{ $penandatangan->pangkat_golongan ?? '' }}<br />
                    NIP. {{ $penandatangan->nip }}
                </p>
            </div>
            @endif

            <div class="signature-col">
                <p>
                    Hormat saya,<br />
                    {{ $p->tugas_tambahan ?? ($p->jenis_ptk ?? '') }}
                </p>
                <br /><br />
                <p>
                    <u>{{ $p->nama ?? 'Nama' }}</u><br />
                    {{ $p->pangkat_golongan ?? '' }}<br />
                    NIP.{{ $p->nip ?? '' }}
                </p>
            </div>

            <div class="clear-float"></div>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('surat-cutis.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>
</body>
</html>
