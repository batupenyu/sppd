<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Data ASN</title>
    <style>
        * { box-sizing: border-box; }
        body {
            background-color: #f3f4f6;
            font-family: "Helvetica", Arial, sans-serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            padding: 15px;
        }
        .preview-container {
            max-width: 100%;
            margin: 0 auto;
        }
        .kop-surat-container {
            text-align: center;
            margin-bottom: 8px;
        }
        .kop-surat-image {
            max-width: 100%;
            max-height: 80px;
            height: auto;
            display: inline-block;
        }
        .header-line {
            border: none;
            border-top: 2px solid #000;
            margin: 6px 0 10px 0;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin-bottom: 6px;
        }
        .subtitle {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 6px;
        }
        .meta {
            text-align: right;
            font-size: 10pt;
            margin-bottom: 8px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        table.data th,
        table.data td {
            border: 1px solid #9ca3af;
            padding: 4px 6px;
            vertical-align: top;
        }
        table.data th {
            background-color: #e5e7eb;
            font-weight: bold;
            text-align: center;
        }
        table.data td {
            text-align: left;
        }
        table.data .num {
            width: 28px;
            text-align: center;
        }
        table.data .nama {
            width: 28%;
        }
        table.data .jk {
            width: 28px;
            text-align: center;
        }
        table.data .nip {
            width: 18%;
        }
        table.data .status {
            width: 22%;
        }
        table.data .jabatan {
            width: auto;
        }
        .page-break {
            page-break-after: always;
            break-after: page;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #d1d5db;
        }
        .no-print {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            position: sticky;
            bottom: 0;
            background: #f3f4f6;
        }
        .no-print button,
        .no-print a {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            margin: 0 4px;
        }
        .no-print a {
            background: #6b7280;
        }
        @media print {
            body { background: white; padding: 0; }
            .page-break {
                page-break-after: always;
                break-after: page;
                border-top: none;
                margin-top: 0;
                padding-top: 0;
            }
            .no-print { display: none !important; }
            table.data th,
            table.data td {
                border: 1px solid #000;
            }
            table.data th {
                background-color: #f2f2f2;
            }
            table.data td { padding: 3px 5px; }
        }
    </style>
</head>
<body>
    <div class="preview-container">
        @foreach($pages as $pageIndex => $page)
            <div class="page">
                <div class="kop-surat-container">
                    @if ($kopSuratBase64)
                        <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
                    @endif
                </div>
                <hr class="header-line">

                <div class="title">DAFTAR DATA ASN</div>
                <div class="subtitle">SMK NEGERI 1 KOBA</div>
                <div class="meta">
                    Halaman {{ $pageIndex + 1 }} dari {{ $pages->count() }}
                </div>

                <table class="data">
                    <thead>
                        <tr>
                            <th class="num">No.</th>
                            <th class="nama">Nama</th>
                            <th class="jk">JK</th>
                            <th class="nip">NIP</th>
                            <th class="status">Status Kepegawaian</th>
                            <th class="jabatan">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($page as $index => $asn)
                        <tr>
                            <td class="num">{{ $pageIndex * 50 + $index + 1 }}</td>
                            <td class="nama">{{ $asn->nama }}</td>
                            <td class="jk">{{ $asn->jk == 'L' ? 'L' : 'P' }}</td>
                            <td class="nip">{{ $asn->nip ?: '-' }}</td>
                            <td class="status">{{ $asn->status_kepegawaian ?: '-' }}</td>
                            <td class="jabatan">{{ $asn->jabatan ?: '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(!$loop->last)
            <div class="page-break"></div>
            @endif
        @endforeach

        @if($pages->isEmpty())
        <div class="page">
            <div class="kop-surat-container">
                @if ($kopSuratBase64)
                    <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
                @endif
            </div>
            <hr class="header-line">
            <div class="title">DAFTAR DATA ASN</div>
            <div class="subtitle">SMK NEGERI 1 KOBA</div>
            <table class="data">
                <thead>
                    <tr>
                        <th class="num">No.</th>
                        <th class="nama">Nama</th>
                        <th class="jk">JK</th>
                        <th class="nip">NIP</th>
                        <th class="status">Status Kepegawaian</th>
                        <th class="jabatan">Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align:center;">Tidak ada data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="no-print">
        <button onclick="window.print()">Cetak</button>
        <a href="{{ route('asns.index') }}">Kembali</a>
    </div>
</body>
</html>