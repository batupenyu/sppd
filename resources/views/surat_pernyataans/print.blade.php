<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <title>Surat Pernyataan - {{ $suratPernyataan->id }}</title>
    <style>
      @page {
        size: A4;
        margin: 1cm 1cm;
      }
      body {
        background-color: #525659;
        font-family: "Times New Roman", Times, serif;
        font-size: 16pt;
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
      .text-center {
        text-align: center;
      }
      .text-left {
        text-align: left;
      }
      .justify {
        text-align: justify;
      }
      .signature-container {
        width: 100%;
        margin-top: 50px;
        overflow: hidden;
      }
      .signature-left {
        width: 50%;
        float: left;
        text-align: center;
      }
      .signature-right {
        width: 50%;
        float: right;
        text-align: center;
      }
      .pegawai-details {
        margin-left: 50px;
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
    <div class="kop-surat-container">
      @if($kopSuratBase64)
      <img
        src="{{ $kopSuratBase64 }}"
        alt="Kop Surat"
        class="kop-surat-image"
      />
      @endif
    </div>

    <div class="text-center">
        <h3>SURAT PERNYATAAN</h3>
    </div>

    <div class="justify">
        <p>{!! nl2br(e($suratPernyataan->pembuka_surat)) !!}</p>
    </div>

    <div class="pegawai-details">
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $suratPernyataan->pegawai->nama ?? '' }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $suratPernyataan->pegawai->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pangkat/Golongan</td>
                <td>:</td>
                <td>{{ $suratPernyataan->pegawai->pangkat ?? '-' }} / {{ $suratPernyataan->pegawai->golongan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $suratPernyataan->pegawai->tugas_tambahan ?: ($suratPernyataan->pegawai->jenis_ptk ?: '') }}</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>:</td>
                <td>{{ $suratPernyataan->pegawai->lembaga_pengangkatan ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="justify">
        <p>{!! nl2br(e($suratPernyataan->isi_surat)) !!}</p>
    </div>

    <div class="justify">
        <p>{!! nl2br(e($suratPernyataan->penutup_surat)) !!}</p>
    </div>

    <div class="signature-container">
        <div class="signature-left">
            <p>Mengetahui, <br>
                {{ $suratPernyataan->penandatangan->jabatan ?? '' }}</p>
            <br>
            <br>
            <br>
            <p><u>{{ $suratPernyataan->penandatangan->nama ?? '' }}</u><br>
                {{ $suratPernyataan->penandatangan->pangkat ?? '' }},
                {{ $suratPernyataan->penandatangan->golongan ?? '' }} <br>
                NIP. {{ $suratPernyataan->penandatangan->nip ?? '' }}</p>
        </div>
        <div class="signature-right">
            <p>{{ $suratPernyataan->tempat_ditetapkan ?? '' }}, {{ \App\Http\Controllers\SuratPernyataanController::formatTanggal($suratPernyataan->tanggal_ditetapkan, '%d %B %Y') }} <br>
                Yang membuat pernyataan,</p>
            <br>
            <br>
            <br>
            <p><u>{{ $suratPernyataan->pegawai->nama ?? '' }}</u> <br>
                {{ $suratPernyataan->pegawai->pangkat ?? '' }}
                {{ $suratPernyataan->pegawai->golongan ?? '' }}<br>
                NIP. {{ $suratPernyataan->pegawai->nip ?? '' }}</p>
        </div>
    </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-pernyataans.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>
  </body>
</html>
