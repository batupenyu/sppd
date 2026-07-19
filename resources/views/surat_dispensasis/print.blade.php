<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Dispensasi - {{ $suratDispensasi->nomor_surat ?: 'Tanpa Nomor' }}</title>
    <style>
        @page {
            size: A4;
            margin: 0 2cm;
        }
        body {
                    background-color: #525659;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.0;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .document-container {
            background-color: #ffffff;
            width: 100%;
            min-height: 297mm;
            padding: 20px 0;
            box-sizing: border-box;
        }
        .kop-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-container img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 18px;
            text-decoration: underline;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }
        .header p {
            font-size: 12pt;
            margin: 0;
        }
        .content {
            font-size: 12pt;
            text-align: justify;
        }
        .meta-table, .schedule-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .meta-table td, .schedule-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .meta-table td:first-child, .schedule-table td:first-child {
            width: 120px;
        }
        .meta-table td:nth-child(2), .schedule-table td:nth-child(2) {
            width: 15px;
            text-align: center;
        }
        .intro-text {
            margin-bottom: 15px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .data-table th, .data-table td {
            border: 1px solid #000000;
            padding: 6px 10px;
            font-size: 12pt;
        }
        .data-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
        .signature-block {
            width: 250px;
            text-align: center;
            font-size: 12pt;
        }
        .signature-space {
            height: 60px;
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
    <div class="page document-container">
        @if ($kopSuratBase64)
        <div class="kop-container">
            <img src="{{ $kopSuratBase64 }}" alt="Kop Surat">
        </div>
        @endif

        <div class="header">
            <h1>SURAT DISPENSASI</h1>
            <p>Nomor: {{ $suratDispensasi->nomor_surat ?: '-' }}</p>
        </div>
        <br />

        <div class="content">
            <p class="intro-text">Yang bertandatangan di bawah ini:</p>

            @php
                $penandatangan = $suratDispensasi->penandatangan;
            @endphp
            <table class="meta-table">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $penandatangan->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $penandatangan->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pangkat/Gol</td>
                    <td>:</td>
                    <td>
                        @if($penandatangan && ($penandatangan->pangkat || $penandatangan->golongan))
                            {{ $penandatangan->pangkat }}@if($penandatangan->pangkat && $penandatangan->golongan), @endif{{ $penandatangan->golongan }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $penandatangan->tugas_tambahan ?? ($penandatangan->jenis_ptk ?? 'Kepala Sekolah') }}</td>
                </tr>
            </table>

            <p class="intro-text">Dengan ini memberikan Dispensasi kepada:</p>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 55%;">Nama</th>
                        <th style="width: 20%;">Kelas</th>
                        <th style="width: 20%;">Ket.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suratDispensasi->pesertaDispensasis as $peserta)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>@if($peserta->ket == 'Siswa'){{ strtoupper($peserta->nama) }}@else{{ $peserta->nama }}@endif</td>
                        <td class="text-center">{{ $peserta->kelas ?: '-' }}</td>
                        <td class="text-center">{{ $peserta->ket ?: '-' }}</td>
                    </tr>
                    @endforeach
                    @if($suratDispensasi->pesertaDispensasis->isEmpty())
                    <tr>
                        <td class="text-center">1</td>
                        <td>-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">Siswa</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <p style="margin-top: 20px;">Untuk mengikuti kegiatan <strong>"{{ $suratDispensasi->nama_kegiatan ?: '-' }}"</strong>, yang dilaksanakan pada :</p>
            <table class="schedule-table" style="margin-left: 20px;">
                <tr>
                    <td>Hari/tanggal</td>
                    <td>:</td>
                    <td>{{ $suratDispensasi->hari_tanggal ?: '-' }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>:</td>
                    <td>{{ $suratDispensasi->waktu ?: '-' }}</td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td>:</td>
                    <td>{{ $suratDispensasi->tempat ?: '-' }}</td>
                </tr>
            </table>

            <p style="margin-top: 25px;">Demikian Surat Dispensasi ini dibuat untuk dapat dilaksanakan sebagaimana mestinya.</p>
        </div>

        <div class="footer">
            <div class="signature-block">
                <p>
                    @if($suratDispensasi->tempat_ditetapkan || $suratDispensasi->tanggal_ditetapkan)
                        {{ $suratDispensasi->tempat_ditetapkan ?: '' }}{{ $suratDispensasi->tempat_ditetapkan && $suratDispensasi->tanggal_ditetapkan ? ', ' : '' }}{{ $suratDispensasi->tanggal_ditetapkan ? \App\Http\Controllers\SuratDispensasiController::formatTanggal($suratDispensasi->tanggal_ditetapkan, '%d %B %Y') : '' }}
                    @else
                        &nbsp;
                    @endif
                    <br>
                    {{ $penandatangan->tugas_tambahan ?? ($penandatangan->jenis_ptk ?? 'Kepala Sekolah') }}
                </p>
                <div class="signature-space"></div>
                <p style="margin-bottom: 0;">{{ $penandatangan->nama ?? 'Nama' }}</p>
                <p style="margin: 0; font-size: 12pt; color: #555;">
                    @if($penandatangan && ($penandatangan->pangkat || $penandatangan->golongan))
                        {{ $penandatangan->pangkat }}@if($penandatangan->pangkat && $penandatangan->golongan),@endif{{ $penandatangan->golongan }}
                    @else
                        Pangkat/gol
                    @endif
                </p>
                <p style="margin: 0;">NIP. {{ $penandatangan->nip ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-dispensasis.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>
</body>
</html>
