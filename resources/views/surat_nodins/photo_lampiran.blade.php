<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <title>Lampiran Foto - {{ $suratNodin->nomor ?: 'Tanpa Nomor' }}</title>
    <style>
      @page {
        size: A4;
        margin: 1cm 1cm 1cm 1cm;
      }
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        font-size: 10pt;
      }
      .header-info {
        margin-bottom: 20px;
        line-height: 1.0;
        font-style: italic;
        page-break-after: avoid;
      }
      .header-info table {
        width: 100%;
        border-collapse: collapse;
        border: none;
      }
      .header-info td {
        padding: 2px 0;
        vertical-align: top;
        border: none;
      }
      .header-info .label {
        width: 120px;
        vertical-align: top;
      }
      .header-info .colon {
        width: 10px;
        vertical-align: top;
      }
      .title {
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        page-break-after: avoid;
      }
      .photo-grid {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        page-break-inside: auto;
      }
      .photo-grid td {
        width: 50%;
        padding: 10px;
        vertical-align: top;
        border: 1px solid #ccc;
        text-align: center;
        page-break-inside: avoid;
      }
      .photo-grid img {
        max-width: 100%;
        max-height: 220px;
        object-fit: contain;
        display: block;
        margin: 0 auto 6px auto;
      }
      .photo-caption {
        font-size: 9pt;
        text-align: center;
        margin: 0;
      }
      .no-photos {
        text-align: center;
        padding: 40px;
        border: 1px solid #ccc;
      }
      .signature-container {
        margin-top: 30px;
        float: right;
        width: 50%;
        text-align: left;
        font-size: 11pt;
        page-break-inside: avoid;
        page-break-after: avoid;
      }
      .signature-title {
        margin-bottom: 60px;
        font-size: 11pt;
      }
      .signature-name {
        font-weight: normal;
        font-size: 11pt;
      }
      .clearfix::after {
        content: "";
        clear: both;
        display: table;
      }
      .signature-unit {
        padding-left: 26px;
        display: block;
        font-size: 11pt;
      }
      .signature-body {
        padding-left: 26px;
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
        body { margin: 0; padding: 0; }
        .page {
          box-shadow: none;
          margin: 0;
          page-break-after: always;
        }
        .no-print {
          display: none !important;
        }
        .photo-grid td {
          border: 1px solid #000;
        }
      }
    </style>
  </head>
  <body>
    <div class="no-print" style="text-align:center; margin-bottom:10px;">
      <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak (PDF)</button>
      <a href="{{ route('surat-nodins.photos', $suratNodin) }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>
    <div class="page">
      <div class="header-info">
        <table>
          <tr>
            <td class="label">LAMPIRAN</td>
            <td class="colon">:</td>
            <td>Foto Kegiatan</td>
          </tr>
          <tr>
            <td class="label">NOMOR</td>
            <td class="colon">:</td>
            <td>{{ $suratNodin->nomor ?: '-' }}</td>
          </tr>
          <tr>
            <td class="label">TANGGAL</td>
            <td class="colon">:</td>
            <td>{{ $suratNodin->tanggal ? \App\Http\Controllers\SuratNodinController::formatTanggal($suratNodin->tanggal, '%d %B %Y') : '-' }}</td>
          </tr>
          <tr>
            <td class="label">PERIHAL</td>
            <td class="colon">:</td>
            <td>{{ $suratNodin->hal ?: '-' }}</td>
          </tr>
        </table>
      </div>

      <div class="title">
        DAFTAR FOTO KEGIATAN
      </div>

      @if($suratNodin->photos->count() > 0)
      <table class="photo-grid">
        @foreach($suratNodin->photos->chunk(2) as $chunk)
        <tr>
          @foreach($chunk as $photo)
            @php
                $src = $photo->image ? 'data:' . ($photo->mime ?: 'image/png') . ';base64,' . base64_encode($photo->image) : '';
            @endphp
            <td>
              @if($src)
                <img src="{{ $src }}" alt="{{ $photo->caption ?: 'Foto' }}" />
              @endif
              @if($photo->caption)
                <p class="photo-caption">{{ $photo->caption }}</p>
              @endif
            </td>
          @endforeach
          @if($chunk->count() == 1)
            <td></td>
          @endif
        </tr>
        @endforeach
      </table>
      @else
      <div class="no-photos">
        Belum ada foto lampiran.
      </div>
      @endif

      <!-- <div class="clearfix">
        <div class="signature-container">
          <div class="signature-title">
            @if(stripos($suratNodin->penandatangan->jabatan ?? '', 'kepala dinas') !== false)
                {{ $suratNodin->penandatangan->jabatan ?? '' }}
            @else
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $suratNodin->penandatangan->jabatan ?? '' }}
            @endif
            <span class="signature-unit">{{ $suratNodin->penandatangan->unit_kerja ?? '' }},</span>
          </div>
          <div class="signature-body">
            <div class="signature-name">{{ $suratNodin->penandatangan->nama ?? '' }}<br>
              @if($suratNodin->penandatangan->pangkat && $suratNodin->penandatangan->pangkat != '-' && $suratNodin->penandatangan->golongan && $suratNodin->penandatangan->golongan != '-')
                {{ $suratNodin->penandatangan->pangkat }}<br>
              @endif
              NIP. {{ $suratNodin->penandatangan->nip ?? '' }}
            </div>
          </div>
        </div>
      </div> -->
    </div>

    <div class="no-print">
      <a href="{{ route('surat-nodins.photos', $suratNodin) }}" style="display:inline-block; margin-right:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
      <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    </div>
  </body>
</html>
