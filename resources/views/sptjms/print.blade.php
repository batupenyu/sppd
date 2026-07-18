<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPTJM - {{ $sptjm->nomor_surat }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm 2cm 0.5cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .kop-surat img {
            max-width: 100%;
            height: auto;
        }
        .text-center {
            text-align: center;
        }
        .signer-section {
            padding-left: 250pt;
            text-align: left;
        }
        .details-table {
            border-collapse: collapse;
            width: 100%;
        }
        .details-table td {
            padding: 1px 0;
            vertical-align: top;
        }
        .details-table .label {
            width: 120px;
        }
        .details-table .colon {
            width: 10px;
            text-align: center;
        }
        .employee-list {
            padding-left: 20px;
        }
        .employee-table {
            width: 100%;
            border-collapse: collapse;
        }
        .employee-table td {
            padding: 1px 5px;
        }
        .employee-table .number {
            width: 5%;
            vertical-align: top;
        }
        .employee-table .label {
            width: 25%;
            vertical-align: top;
        }
        .employee-table .colon {
            width: 5%;
            text-align: center;
            vertical-align: top;
        }
        .employee-table .value {
            width: 65%;
            vertical-align: top;
            white-space: nowrap;
        }
        .closing-section {
            margin-top: 15px;
        }
        .signature-section {
            margin-top: 60px;
        }
        .kop-surat-container {
            text-align: center;
            margin-bottom: 10px;
            margin-left: -2cm;
            margin-right: -2cm;
        }
        .kop-surat-image {
            width: 80%;
            max-width: 21cm;
            height: auto;
            max-height: 200px;
            object-fit: contain;
        }
        .no-print { margin-top: 20px; text-align: center; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="kop-surat-container">
        @if ($kopSuratBase64)
            <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
        @endif
    </div>

    @php
        $fmt = [\App\Http\Controllers\SptjmController::class, 'formatTanggal'];
        $p = $sptjm->penandatangan;
        $pegawai = $sptjm->pegawai;
    @endphp

    <div class="text-center">
        <p><b><u>SURAT PERTANGGUNGJAWABAN MUTLAK</u></b><br>
        Nomor: {{ $sptjm->nomor_surat ?: '-' }}</p>
    </div>

    <p>Yang bertanda tangan di bawah ini:</p>
    @if ($p)
    <table class="details-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $p->nama }}</td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="colon">:</td>
            <td>{{ $p->nip }}</td>
        </tr>
        <tr>
            <td class="label">Pangkat/Golongan</td>
            <td class="colon">:</td>
            <td>{{ $p->pangkat_golongan ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $p->tugas_tambahan ?: ($p->jenis_ptk ?: '-') }}</td>
        </tr>
    </table>
    <!-- @else
    <p><em>Penandatangan tidak ditentukan.</em></p>
    @endif -->

    <p>Menyatakan bahwa bahwa:</p>
    <!-- <div class="employee-list">
        @if ($pegawai->isNotEmpty())
            @if ($pegawai->count() > 1)
                <table class="employee-table">
                    @foreach ($pegawai as $i => $emp)
                    <tr>
                        <td class="number">{{ $i + 1 }}.</td>
                        <td class="label">Nama</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $emp->nama }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="label">NIP</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $emp->nip }}</td>
                    </tr>
                    @endforeach
                </table>
            @else
                @foreach ($pegawai as $emp)
                <table class="employee-table">
                    <tr>
                        <td class="label" style="padding-left: 20px;">Nama</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $emp->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label" style="padding-left: 20px;">NIP</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $emp->nip }}</td>
                    </tr>
                </table>
                @endforeach
            @endif
        @else
            <p><em>Tidak ada pegawai yang tercantum.</em></p>
        @endif
    </div> -->

    <div style="margin-top: 20px; text-align: justify;">
        {!! nl2br(e($sptjm->isi_surat)) !!}
    </div>

    <div class="closing-section" style="text-align: justify;">
        {!! nl2br(e($sptjm->penutup_surat)) !!}
    </div>

    <div class="signer-section">
        <p>
            {{ $sptjm->tempat_ditetapkan ?: '-' }}, {{ $fmt($sptjm->tanggal_ditetapkan, '%d %B %Y') }}<br>
            @if ($p)
                {{ $p->tugas_tambahan ?: ($p->jenis_ptk ?: '') }},
                <div class="signature-section">
                    <strong>{{ $p->nama }}</strong><br>
                    {{ $p->pangkat_golongan ?: '' }}<br>
                    NIP. {{ $p->nip }}
                </div>
            @else
                [Jabatan Penandatangan]
                <div class="signature-section">
                    <strong>[Nama Penandatangan]</strong><br>
                    [Pangkat Penandatangan]<br>
                    NIP. [NIP Penandatangan]
                </div>
            @endif
        </p>
    </div>

    <div class="no-print">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('sptjms.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>

</body>
</html>
