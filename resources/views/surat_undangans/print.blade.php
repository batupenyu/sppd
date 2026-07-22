<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <title>Surat Undangan - {{ $suratUndangan->nomor_surat }}</title>
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
        font-family: "Times New Roman", Times, serif;
        font-size: 16pt;
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
      .info-table {
        width: 100%;
        border-collapse: collapse;
        margin: 12px 0;
      }
      .info-table td {
        padding: 1px 8px 1px 0;
        vertical-align: top;
      }
      .info-table td.label {
        width: 110px;
        font-weight: 500;
        white-space: nowrap;
      }
      .info-table td:last-child {
        padding-left: 20px;
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
        justify-content: flex-end;
        align-items: flex-end;
        position: relative;
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
      .no-print {
        margin-top: 20px;
        text-align: center;
      }
      @media print {
        body {
          margin: 0;
          padding: 0;
        }
        .page {
          box-shadow: none;
          margin: 0;
          page-break-after: always;
        }
        .no-print {
          display: none !important;
        }
        .signature-wrapper {
          break-inside: avoid;
        }
      }
    </style>
  </head>
  <body>
    <div class="page">
    <div class="kop-container">
      @if($kopSuratBase64)
      <img
        src="{{ $kopSuratBase64 }}"
        alt="Kop Surat"
        style="max-width: 100%; height: auto; display: block; margin: 0 auto 10px auto;"
      />
      @endif
    </div>

    <div class="letter-header">
      <table class="header-details">
        <tr>
          <td class="label">Nomor</td>
          <td class="content">: {{ $suratUndangan->nomor_surat ?: '___/___/___/____' }}</td>
        </tr>
        <tr>
          <td class="label">Lamp.</td>
          <td class="content">: -</td>
        </tr>
        <tr>
          <td class="label">Perihal</td>
          <td class="content">: <strong>{{ $suratUndangan->perihal ?: 'Undangan Orang Tua Siswa' }}</strong></td>
        </tr>
      </table>
    </div>

    <div class="alamat-tujuan">
      @if($suratUndangan->kepada_yth)
      <p>Yth. {{ $suratUndangan->kepada_yth }}</p>
      @else
      <p>Yth. Bapak/Ibu Orang Tua/Wali dari Siswa</p>
      @endif
      @if($suratUndangan->siswa)
      <p><strong>{{ $suratUndangan->siswa->nama }}</strong></p>
      @endif
      <p>di</p>
      <p>Tempat</p>
    </div>

    <p style="text-indent: 1cm; margin-top: 15px; text-align: justify;">
      @if($suratUndangan->pembuka_surat)
        {!! nl2br(e($suratUndangan->pembuka_surat)) !!}
      @else
        Dengan ini kami mengundang {{ $suratUndangan->kepada_yth ?: 'Bapak/Ibu orang tua/wali dari siswa yang namanya tersebut di atas' }} untuk hadir pada:
      @endif
    </p>

    <table class="info-table">
      <tr>
        <td class="label">Hari/Tanggal</td>
        <td>:</td>
        <td>{{ $suratUndangan->tanggal ? \App\Http\Controllers\SuratUndanganController::formatTanggal($suratUndangan->tanggal, '%A, %d %B %Y') : '_________, __________' }}</td>
      </tr>
      <tr>
        <td class="label">Waktu</td>
        <td>:</td>
        <td>{{ $suratUndangan->waktu ?: '________ WITA' }} WITA</td>
      </tr>
      <tr>
        <td class="label">Tempat</td>
        <td>:</td>
        <td>{{ $suratUndangan->tempat ?: 'SMK Negeri 1 Koba' }}</td>
      </tr>
    </table>

    <table class="info-table">
      <tr>
        <td class="label">Acara</td>
        <td>:</td>
        <td style="text-align: justify;">{!! nl2br(e($suratUndangan->acara ?: '-')) !!}</td>
      </tr>
    </table>

    <p style="text-indent: 1cm; margin-top: 15px; text-align: justify;">
      @if($suratUndangan->penutup_surat)
        {!! nl2br(e($suratUndangan->penutup_surat)) !!}
      @else
        Demikian undangan ini kami sampaikan, atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.
      @endif
    </p>

    <div class="signature-wrapper">
      <div class="signature-right">
        <div class="signature-item">
          <div class="jabatan">Kepala Sekolah,</div>
          <div style="margin-bottom: 25px;"></div>
          @if($suratUndangan->kepalaSekolah)
          <div class="nama">
            {{ $suratUndangan->kepalaSekolah->nama }}
          </div>
          <div class="nip">
            NIP. {{ $suratUndangan->kepalaSekolah->nip }}
          </div>
          @else
          <div class="nama placeholder-sign">
            _________________________
          </div>
          @endif
        </div>
      </div>
    </div>

    @if($suratUndangan->tempat_ditetapkan && $suratUndangan->tanggal_ditetapkan)
    <div style="margin-top: 25px; font-size: 10pt; text-align: right; border-top: 1px dashed #ccc; padding-top: 8px;">
      <em>Dikeluarkan di : {{ $suratUndangan->tempat_ditetapkan }}, {{ \App\Http\Controllers\SuratUndanganController::formatTanggal($suratUndangan->tanggal_ditetapkan, '%d %B %Y') }}</em>
    </div>
    @endif

    <footer>
      * Surat ini bersifat resmi dan harap dibawa saat pertemuan.
    </footer>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-undangans.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>
  </body>
</html>
