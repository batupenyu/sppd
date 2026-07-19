@php($s = $suratPanggilanSiswa ?? null)
@php($waliKelas = $s->waliKelas ?? null)
@php($guruBk = $s->guruBk ?? null)
@php($wakasek = $s->wakasekKesiswaan ?? null)
@php($siswa = $s->siswa ?? null)
@php($fmt = \App\Http\Controllers\SuratPanggilanSiswaController::class)

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Panggilan Orang Tua Siswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0.5cm 2cm 0.5cm 2.5cm;
        }

        body {
                    background-color: #525659;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
            background: white;
        }

        .kop-container {
            margin-bottom: 20px;
            text-align: center;
        }
        .kop-container img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 10px auto;
        }

        .letter-header {
            margin-top: 5px;
            margin-bottom: 20px;
        }
        .header-details {
            width: 100%;
            border-collapse: collapse;
        }
        .header-details td {
            padding: 3px 5px;
            vertical-align: top;
        }
        .header-details td.label {
            width: 80px;
            font-weight: normal;
        }
        .header-details td.content {
            font-weight: normal;
        }

        .surat-title {
            text-align: center;
            margin: 15px 0 5px 0;
        }
        .surat-title strong {
            font-size: 14pt;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .alamat-tujuan {
            margin: 20px 0 10px 0;
        }
        .alamat-tujuan p {
            margin: 4px 0;
        }

        .student-identity {
            margin: 10px 0 15px 0;
            background: #f9f9f9;
            padding: 8px 12px;
            border-left: 4px solid #2c3e66;
            border-radius: 0 6px 6px 0;
        }
        .student-name-line {
            font-weight: bold;
            font-size: 12.5pt;
            margin-bottom: 6px;
        }
        .student-details {
            font-size: 11pt;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }
        .info-table td {
            padding: 5px 8px 5px 0;
            vertical-align: top;
        }
        .info-table td.label {
            width: 110px;
            font-weight: 500;
        }
        .acara-text, .bertemu-text {
            text-align: justify;
            margin-top: 6px;
            margin-bottom: 8px;
        }

        .closing-paragraph {
            text-align: justify;
            margin: 18px 0 25px 0;
            line-height: 1.5;
        }

        .signature-wrapper {
            margin-top: 35px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-end;
            position: relative;
        }
        .signature-left {
            width: 45%;
            text-align: center;
        }
        .signature-right {
            width: 45%;
            text-align: center;
        }
        .signature-item {
            margin-bottom: 28px;
        }
        .signature-item .jabatan {
            font-weight: 600;
            margin-bottom: 35px;
            font-size: 12pt;
        }
        .signature-item .nama {
            margin-top: 5px;
            font-weight: 600;
            text-decoration: underline;
            margin-bottom: 2px;
        }
        .signature-item .nip {
            font-size: 11pt;
        }
        .mengetahui-wrapper {
            margin-top: 20px;
            clear: both;
            width: 100%;
            text-align: center;
        }
        .mengetahui-block {
            margin-top: 10px;
            display: inline-block;
            text-align: center;
        }
        .mengetahui-block .jabatan-mengetahui {
            font-weight: 600;
            margin-bottom: 35px;
        }
        .mengetahui-block .nama-mengetahui {
            font-weight: 600;
            text-decoration: underline;
            margin-top: 5px;
        }
        .signature-line {
            margin-top: 5px;
        }
        hr.dotted {
            border: none;
            border-top: 1px dotted #333;
            margin: 8px 0;
        }

        .clearfix {
            clear: both;
        }
        .text-justify {
            text-align: justify;
        }
        .indent-text {
            text-indent: 2.5cm;
        }
        .mt-2 {
            margin-top: 8px;
        }
        .mb-1 {
            margin-bottom: 4px;
        }
        .bold {
            font-weight: bold;
        }
        .italic {
            font-style: italic;
        }

        .placeholder-sign {
            color: #555;
            font-style: normal;
        }
        hr {
            border: 0.5px solid #aaa;
            margin: 8px 0;
        }
        footer {
            font-size: 9pt;
            text-align: center;
            margin-top: 35px;
            color: #444;
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
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            .page {
                box-shadow: none;
                margin: 0;
                page-break-after: always;
            }
            .signature-wrapper {
                break-inside: avoid;
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
    <div class="kop-container">
        <img src="{{ $kopSuratBase64 }}" alt="Kop Surat Sekolah">
    </div>
    @endif

    <div class="letter-header">
        <table class="header-details">
            <tr>
                <td class="label">Nomor</td>
                <td class="content">: {{ $s->nomor_surat ?: '___/___/___/____' }}</td>
            </tr>
            <tr>
                <td class="label">Lamp.</td>
                <td class="content">: -</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td class="content">: <strong>Surat Panggilan Orang Tua Siswa {{ $s->keterangan_panggilan_display }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="alamat-tujuan">
        <p>Yth. Bapak/Ibu Orang Tua/Wali dari Siswa :</p>
        <p><strong>{{ $siswa->nama ?? '(Nama Siswa)' }}</strong></p>
        <p>di –</p>
        <p><strong>{{ $s->tempat_panggilan ?: 'SMK Negeri 2 Pelaihari' }}</strong></p>
    </div>

  <p style="text-indent: 1cm; margin-top: 15px; text-align: justify;">
  Dengan ini kami mengharapkan kehadiran Bapak/Ibu orang tua/wali dari siswa yang namanya tersebut di atas pada:
  </p>

    <table class="info-table">
        <tr>
            <td class="label">Hari/Tanggal</td>
            <td>: {{ $s->tanggal_panggilan ? $fmt::formatTanggal($s->tanggal_panggilan, '%A, %d %B %Y') : '_________, __________' }}</td>
        </tr>
        <tr>
            <td class="label">Waktu</td>
            <td>: {{ $s->waktu_panggilan ?: '________ WITA' }} WITA</td>
        </tr>
        <tr>
            <td class="label">Tempat</td>
            <td>: {{ $s->tempat_panggilan ?: 'SMK Negeri 2 Pelaihari, Jln. Husni Thamrin Rt.6 Desa Pemuda KNPI Kec. Pelaihari' }}</td>
        </tr>
    </table>

    <p style="text-indent: 1cm; margin-top: 15px; text-align: justify;">
        Mengingat pentingnya masalah tersebut, kehadiran Bapak/Ibu orang tua siswa sangat kami harapkan.
    </p>

    <p style="text-indent: 1cm; margin-top: 15px; text-align: justify;">
        Demikian undangan ini kami sampaikan, atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.
    </p>

    <div class="signature-wrapper">
        <div class="signature-left">
            <div class="signature-item">
                <div class="jabatan">Wali Kelas,</div>
                <div style="margin-bottom: 25px;"></div>
                @if($waliKelas)
                <div class="nama">
                    {{ $waliKelas->nama }}
                </div>
                <div class="nip">
                    NIP. {{ $waliKelas->nip }}
                </div>
                @else
                <div class="nama placeholder-sign">
                    _________________________
                </div>
                @endif
            </div>
        </div>

        <div class="signature-right">
            <div class="signature-item">
                <div class="jabatan">Guru Bimbingan Konseling,</div>
                <div style="margin-bottom: 25px;"></div>
                @if($guruBk)
                <div class="nama">
                    {{ $guruBk->nama }}
                </div>
                <div class="nip">
                    NIP. {{ $guruBk->nip }}
                </div>
                @else
                <div class="nama placeholder-sign">
                    _________________________
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mengetahui-wrapper">
        <div class="mengetahui-block">
            <div class="jabatan-mengetahui">Mengetahui :<br>Wakil Kepala Sekolah Bidang Kesiswaan,</div>
            <div style="margin-bottom: 30px;"></div>
            @if($wakasek)
            <div class="nama-mengetahui">
                {{ $wakasek->nama }}
            </div>
            <div class="nip">
                NIP. {{ $wakasek->nip }}
            </div>
            @else
            <div class="nama-mengetahui placeholder-sign">
                _________________________
            </div>
            @endif
        </div>
    </div>

    @if($s->tempat_ditetapkan && $s->tanggal_ditetapkan)
    <div style="margin-top: 25px; font-size: 10pt; text-align: right; border-top: 1px dashed #ccc; padding-top: 8px;">
        <em>Dikeluarkan di : {{ $s->tempat_ditetapkan }}, {{ $fmt::formatTanggal($s->tanggal_ditetapkan, '%d %B %Y') }}</em>
    </div>
    @endif

    <footer>
        * Surat ini bersifat resmi dan harap dibawa saat pertemuan.
    </footer>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
        <a href="{{ route('surat-panggilan-siswas.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>
    </div>
</body>
</html>
