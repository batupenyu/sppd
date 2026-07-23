<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Surat Penunjukan Mewakili - {{ $suratMewakili->nomor ?: $suratMewakili->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.5;
            font-size: 16pt;
            margin: 1cm 1cm;
            padding: 40px;
            background-color: #525659;
            display: flex;
            justify-content: center;
        }
        .sheet {
            background-color: white;
            width: 210mm;
            min-height: 297mm;
            padding: 1cm 2cm;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            box-sizing: border-box;
        }
        .kop-surat-container {
            text-align: center;
            margin-bottom: 10px;
            margin-left: -1.5cm;
            margin-right: -1.5cm;
        }
        .kop-surat-image {
            width: 80%;
            max-width: 21cm;
            height: auto;
            max-height: 150px;
            object-fit: contain;
        }
        .document-title { text-align: center; margin-top: 6px; margin-bottom: 14px; }
        .document-title h4 { margin: 0; font-size: 15px; text-transform: uppercase; text-decoration: underline; font-weight: bold; letter-spacing: 0.5px; }
        .document-title p { margin: 4px 0 0 0; font-size: 13px; }
        .content-section { font-size: 13px; text-align: justify; margin-bottom: 8px; }
        .data-table { width: 100%; margin-top: 6px; margin-bottom: 8px; font-size: 13px; border-collapse: collapse; }
        .data-table td { padding: 1px 0; vertical-align: top; }
        .data-table td.label { width: 110px; }
        .data-table td.colon { width: 15px; text-align: center; }
        .provisions-list { margin-top: 4px; margin-bottom: 8px; padding-left: 18px; }
        .provisions-list li { font-size: 13px; text-align: justify; margin-bottom: 4px; list-style-type: none; position: relative; }
        .provisions-list li::before { content: attr(data-number) ". "; position: absolute; left: -18px; }
        .signature-section { width: 100%; margin-top: 18px; font-size: 13px; }
        .signature-table { float: right; width: 280px; text-align: left; }
        .signature-space { height: 50px; }
        .tembusan { margin-top: 25px; font-size: 11px; clear: both; }
        .tembusan p { margin: 0; font-style: italic; text-decoration: underline; }
        .tembusan ol { margin: 5px 0 0 0; padding-left: 15px; }
        .tembusan li { margin-bottom: 2px; }
        @media print {
            body { background: white; padding: 0; }
            .sheet { box-shadow: none; margin: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="sheet">
    <div class="kop-surat-container">
        @if($kopSuratBase64)
        <img
            src="{{ $kopSuratBase64 }}"
            alt="Kop Surat"
            class="kop-surat-image"
        />
        @endif
    </div>

    <div class="document-title">
        <h4>Surat Penunjukan Mewakili</h4>
        <p>Nomor : {{ $suratMewakili->nomor ?: '800/ ...... / SMKN 1 Kb/Dindik/2026' }}</p>
    </div>

    <div class="content-section">
        Yang bertanda tangan di bawah ini :
    </div>

    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td><strong>{{ $suratMewakili->penunjuk_nama ?: ($suratMewakili->penunjuk->nama ?? '') }}</strong></td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="colon">:</td>
            <td>{{ $suratMewakili->penunjuk_nip ?: ($suratMewakili->penunjuk->nip ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label">Pangkat/Gol</td>
            <td class="colon">:</td>
            <td>{{ $suratMewakili->penunjuk_pangkat_gol ?: (($suratMewakili->penunjuk->pangkat ?? '') . ' / ' . ($suratMewakili->penunjuk->golongan ?? '')) }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $suratMewakili->penunjuk_jabatan ?: ($suratMewakili->penunjuk->jabatan ?? '') }}</td>
        </tr>
    </table>

    <div class="content-section">
        {{ $suratMewakili->keterangan_menunjuk }}
    </div>

    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td><strong>{{ $suratMewakili->ditunjuk_nama ?: ($suratMewakili->ditunjuk->nama ?? '') }}</strong></td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="colon">:</td>
            <td>{{ $suratMewakili->ditunjuk_nip ?: ($suratMewakili->ditunjuk->nip ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label">Instansi</td>
            <td class="colon">:</td>
            <td>{{ $suratMewakili->ditunjuk_instansi ?: 'SMK N 1 Koba' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $suratMewakili->ditunjuk_jabatan ?: ($suratMewakili->ditunjuk->jabatan ?? '') }}</td>
        </tr>
    </table>

    <div class="content-section">
        {{ $suratMewakili->keterangan_mewakili }}
    </div>

    <ul class="provisions-list">
        @foreach(($suratMewakili->ketentuan ?? []) as $index => $item)
        <li data-number="{{ $index + 1 }}">{{ $item }}</li>
        @endforeach
    </ul>

    <div class="content-section">
        {{ $suratMewakili->penutup }}
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td>{{ $suratMewakili->dikeluarkan_di ?: 'Koba' }}, {{ \App\Http\Controllers\SuratMewakiliController::formatTanggal($suratMewakili->tanggal_dikeluarkan, '%d %B %Y') }}</td>
            </tr>
            <tr>
                <td>Kepala Sekolah,</td>
            </tr>
            <tr>
                <td class="signature-space"></td>
            </tr>
            <tr>
                <td><strong><u>{{ $suratMewakili->penunjuk_nama ?: ($suratMewakili->penunjuk->nama ?? '') }}</u></strong><br>
                {{ $suratMewakili->penunjuk_pangkat_gol ?: (($suratMewakili->penunjuk->pangkat ?? '') . ' / ' . ($suratMewakili->penunjuk->golongan ?? '')) }}<br>
                NIP {{ $suratMewakili->penunjuk_nip ?: ($suratMewakili->penunjuk->nip ?? '') }}</td>
            </tr>
        </table>
    </div>

    <div class="tembusan">
        <p>Tembusan Yth. :</p>
        <ol>
            <li>Kepala Cabang Dinas Wilayah I Dinas Pendidikan Provinsi Kepulauan Bangka Belitung</li>
            <li>Arsip.</li>
        </ol>
    </div>
</div>

<div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-mewakili.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>

</body>
</html>
