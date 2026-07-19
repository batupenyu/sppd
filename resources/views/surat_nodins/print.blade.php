<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <title>Nota Dinas - {{ $suratNodin->nomor }}</title>
    <style>
      @page {
        size: A4;
        margin: 1cm 2cm 0.5cm 2cm;
      }
      body {
                  background-color: #525659;
        font-family: Arial, sans-serif;
        font-size: 11pt;
        line-height: 1.5;
        color: #000;
        margin: 0;
        background: #fff;
      }
      * {
        font-size: inherit;
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
      .nota-title {
        text-align: center;
        font-size: 11pt;
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 20px;
        text-transform: uppercase;
      }
      .meta-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 11pt;
        page-break-inside: avoid;
      }
      .meta-table td {
        vertical-align: top;
        font-size: 11pt;
      }
      .meta-table td:nth-child(1) { width: 12%; }
      .meta-table td:nth-child(2) { width: 3%; text-align: center; }
      .meta-table td:nth-child(3) { width: 85%; }
      .peserta-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 11pt;
        page-break-inside: auto;
      }
      .peserta-table th,
      .peserta-table td {
        border: 1px solid #000;
        padding: 6px;
        font-size: 11pt;
        text-align: left;
      }
      .peserta-table th {
        font-weight: bold;
        background-color: #e6e6e6;
        text-align: center;
      }
      .content {
        text-align: justify;
        text-indent: 40px;
        margin-bottom: 15px;
        font-size: 11pt;
        page-break-inside: avoid;
      }
      .content p {
        margin: 0 0 15px 0;
        font-size: 11pt;
      }
      .signature-container {
        margin-top: 40px;
        float: right;
        width: 50%;
        text-align: left;
        font-size: 11pt;
        page-break-inside: avoid;
        page-break-after: avoid;
      }
      .signature-title {
        font-weight: bold;
        margin-bottom: 60px;
        font-size: 11pt;
      }
      .signature-name {
        font-weight: bold;
        font-size: 11pt;
      }
      .clearfix::after {
        content: "";
        clear: both;
        display: table;
      }
      .signature-unit {
        padding-left: 29px;
        display: block;
        font-size: 11pt;
      }
      .signature-body {
        padding-left: 29px;
        font-size: 11pt;
      }
      .signature-nip {
        margin-top: 5px;
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
        .signature-container {
          break-inside: avoid;
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

    <div class="nota-title">Nota Dinas</div>

    <table class="meta-table">
      <tr>
        <td>Yth.</td>
        <td>:</td>
        <td>{{ $suratNodin->kepada ?: '-' }}</td>
      </tr>
      <tr>
        <td>Dari</td>
        <td>:</td>
        <td>{{ $suratNodin->dari ?: '-' }}</td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td>{{ $suratNodin->tanggal ? \App\Http\Controllers\SuratNodinController::formatTanggal($suratNodin->tanggal, '%d %B %Y') : '-' }}</td>
      </tr>
      <tr>
        <td>Nomor</td>
        <td>:</td>
        <td>{{ $suratNodin->nomor ?: '-' }}</td>
      </tr>
      <tr>
        <td>Sifat</td>
        <td>:</td>
        <td>{{ $suratNodin->sifat ?: '-' }}</td>
      </tr>
      <tr>
        <td>Lampiran</td>
        <td>:</td>
        <td>{{ $suratNodin->lampiran ?: '-' }}</td>
      </tr>
      <tr>
        <td>Hal</td>
        <td>:</td>
        <td>{{ $suratNodin->hal ?: '-' }}</td>
      </tr>
    </table>

    <hr style="border: 0; border-top: 1px solid #000; margin-bottom: 20px;">

    @if($suratNodin->dasar_surat)
    <div class="content">
      <p>{{ $suratNodin->dasar_surat }}</p>
    </div>
    @endif

    @if($suratNodin->isi_surat)
    <div class="content">
        <p>{{ $suratNodin->isi_surat }}</p>
    </div>
    @endif

    <table class="peserta-table">
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 22%;">Nama</th>
          <th style="width: 18%;">NIP/NIS</th>
          <th style="width: 15%;">Pangkat / Gol</th>
          <th style="width: 15%;">Jabatan</th>
          <th style="width: 12%;">Tanggal/Tempat Kegiatan</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $pesertaList = $suratNodin->pesertaSuratUsulans;
            $groups = [];
            foreach ($pesertaList as $peserta) {
                $key = ($peserta->tanggal_kegiatan ?? '') . '|' . ($peserta->tempat_kegiatan ?? '');
                if (!isset($groups[$key])) {
                    $groups[$key] = [
                        'items' => [],
                        'tanggal' => $peserta->tanggal_kegiatan,
                        'tempat' => $peserta->tempat_kegiatan,
                    ];
                }
                $groups[$key]['items'][] = $peserta;
            }
            $no = 0;
        ?>

        @foreach($groups as $group)
            <?php $rowspan = count($group['items']); ?>
            @foreach($group['items'] as $index => $peserta)
                <tr>
                  <td style="text-align: center;"><?php echo e($no + $index + 1); ?>.</td>
                  <td>
                    @if($peserta->pegawai)
                      {{ $peserta->pegawai->nama }}
                    @elseif($peserta->siswa)
                      {{ $peserta->siswa->nama }}
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if($peserta->pegawai)
                      {{ $peserta->pegawai->nip ?: '-' }}
                    @elseif($peserta->siswa)
                      {{ $peserta->siswa->nis ?: '-' }}
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if($peserta->pegawai)
                      @if($peserta->pegawai->pangkat && $peserta->pegawai->pangkat != '-' && $peserta->pegawai->golongan && $peserta->pegawai->golongan != '-')
                        {{ $peserta->pegawai->pangkat }},{{ $peserta->pegawai->golongan }}
                      @else
                        -
                      @endif
                    @elseif($peserta->siswa)
                      {{ $peserta->siswa->kelas ?: '-' }}
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if($peserta->pegawai)
                      {{ $peserta->pegawai->jabatan ?: '-' }}
                    @elseif($peserta->siswa)
                      Siswa
                    @else
                      -
                    @endif
                  </td>
                  <?php if($index == 0): ?>
                  <td rowspan="<?php echo e($rowspan); ?>">
                    {{ $peserta->tanggal_kegiatan ? \App\Http\Controllers\SuratNodinController::formatTanggal($peserta->tanggal_kegiatan, '%d %B %Y') : '-' }} di {{ $peserta->tempat_kegiatan ?: '-' }}
                  </td>
                  <?php endif; ?>
                </tr>
            @endforeach
            <?php $no += $rowspan; ?>
        @endforeach
        @if($suratNodin->pesertaSuratUsulans->isEmpty())
        <tr>
          <td colspan="6" class="text-center">Tidak ada data peserta.</td>
        </tr>
        @endif

      </tbody>
    </table>

    <div class="content">
      <p>Demikian surat permohonan ini kami sampaikan. Atas perhatian Bapak, Kami sampaikan terima kasih.</p>
    </div>

    <div class="clearfix">
      <div class="signature-container">
        <div class="signature-title">
            @if(stripos($suratNodin->penandatangan->jabatan ?? '', 'kepala dinas') !== false)
                {{ $suratNodin->penandatangan->jabatan ?? '' }}
            @else
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $suratNodin->penandatangan->jabatan ?? '' }}
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
    </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-nodins.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>
  </body>
</html>
