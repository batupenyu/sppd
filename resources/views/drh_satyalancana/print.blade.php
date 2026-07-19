<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Riwayat Hidup - Usul Tanda Kehormatan</title>
    <style>
        body {
                    background-color: #525659;
            font-family: Arial, sans-serif;
            line-height: 1.4;
            margin: 40px;
            color: #000;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 25px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 10px;
            vertical-align: top;
            font-size: 13px;
        }
        .center-text {
            text-align: center;
        }
        .strike {
            text-decoration: line-through;
        }
        .signature-container {
            width: 100%;
            margin-top: 20px;
            font-size: 13px;
            padding-left: 50px;
        }
        .signature-table {
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none;
            padding: 0;
            width: 50%;
        }
        .space-tg {
            height: 15px;
        }
        .space-ttd {
            height: 65px;
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
        .kop-surat-container {
            text-align: center;
            margin-bottom: 20px;
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

    @php
        $asn = $drh->asn ?? new class {
            public function __get($key) { return null; }
        };
        $fmt = [\App\Http\Controllers\DrhSatyalancanaController::class, 'formatTanggal'];
    @endphp

    <div class="page">
    <!-- <div class="kop-surat-container">
        @if($kopSuratBase64)
            <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
        @endif
    </div> -->

    <div class="header">
        DAFTAR RIWAYAT HIDUP<br>
        USUL TANDA KEHORMATAN SATYALANCANA KARYA SATYA
    </div>

    <table>
        <tbody>
            <tr>
                <td class="center-text" style="width: 5%;">1.</td>
                <td style="width: 45%;">Nama Lengkap</td>
                <td style="width: 50%; font-weight: bold;">{{ $asn->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="center-text">2.</td>
                <td>Tempat, Tanggal Lahir</td>
                <td>{{ $asn->tempat_lahir ?? '-' }}, {{ $fmt($asn->tanggal_lahir, '%d-%m-%Y') }}</td>
            </tr>
            <tr>
                <td class="center-text">3.</td>
                <td>NIP</td>
                <td>{{ $asn->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="center-text">4.</td>
                <td>NIP Lama (jika ada)</td>
                <td>{{ $drh->nip_lama ?: '-' }}</td>
            </tr>
            <tr>
                <td class="center-text">5.</td>
                <td>Pendidikan Terakhir</td>
                <td>{{ $drh->pendidikan_terakhir ?: '-' }}</td>
            </tr>
            <tr>
                <td class="center-text">6.</td>
                <td>Pangkat, Gol. Ruang Terakhir (TMT)</td>
                <td>{{ $drh->pangkat ?: '-' }} ({{ $fmt($drh->tmt_pangkat, '%d %B %Y') }})</td>
            </tr>
            <tr>
                <td class="center-text">7.</td>
                <td>No. SK CPNS (TMT)</td>
                <td>{{ $drh->no_sk_cpns ?: '-' }} ({{ $fmt($drh->tmt_cpns, '%d %B %Y') }})</td>
            </tr>
            <tr>
                <td class="center-text">8.</td>
                <td>Jabatan Terakhir (TMT)</td>
                <td>{{ $drh->jabatan_terakhir ?: '-' }} ({{ $fmt($drh->tmt_jabatan, '%d %B %Y') }})</td>
            </tr>
            <tr>
                <td class="center-text">9.</td>
                <td>Jenis Kelamin</td>
                <td>(<span class="{{ ($asn->jk ?? '') == 'P' ? 'strike' : '' }}">Pria</span> / <span class="{{ ($asn->jk ?? '') == 'L' ? 'strike' : '' }}">Wanita</span>, coret yang tidak perlu)</td>
            </tr>
            <tr>
                <td class="center-text">10.</td>
                <td>Tanda Kehormatan yang sudah dimiliki (Nomor dan tanggal Keppres)</td>
                <td>sudah mendapatkan SLKS yang ke {{ $drh->tanda_kehormatan ?: '-' }} ({{ $fmt($drh->tgl_kepres, '%d %B %Y') }} dan {{ $drh->no_kepres ?: '-' }})</td>
            </tr>
            <tr>
                <td class="center-text">11.</td>
                <td>Hukuman Disiplin (Jenis, Nomor dan TMT dijatuhi hukuman s.d selesai)</td>
                <td style="font-style: italic;">{{ $drh->hukuman_disiplin ?: 'tidak pernah dijatuhi hukuman disiplin tingkat sedang/berat' }}</td>
            </tr>
            <tr>
                <td class="center-text">12.</td>
                <td>CLTN (Nomor, dan TMT CLTN s.d selesai)</td>
                <td style="font-style: italic;">{{ $drh->cltn ?: 'tidak pernah mengambil cuti di luar tanggungan negara (CLTN)' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td><br>Jabatan Atasan Langsung,
                <td>
                    Ditetapkan di Pangkalpinang<br>
                    Tanggal : {{ $fmt($drh->created_at, '%d %B %Y') }}
                </td>
            </tr>
            <tr class="space-tg">
                <td></td>
                <td></td>
            </tr>
            <tr class="space-ttd">
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-decoration: underline;">
                    {{ $drh->atasan_nama ?: 'SAIPUL BAKHRI, S.Pd., M.M.' }}
                </td>
                <td style="font-weight: bold; text-decoration: underline;">{{ $asn->nama ?? '' }}</td>
            </tr>
            <tr>
                <td>
                    NIP. {{ $drh->atasan_nip ?: '19740304 200501 1 013' }}
                </td>
                <td>NIP. {{ $asn->nip ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="no-print">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('drh-satyalancana.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>
    </div>

</body>
</html>
