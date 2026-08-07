<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <title>Nota Dinas - {{ $suratNodin->nomor }}</title>
    <style>
      @page {
        size: A4;
        margin: 1cm 1cm;
      }
      body {
        background-color: #525659;
        font-family: Arial, sans-serif;
        font-size: 13pt;
        line-height: 1.3;
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
        font-size: 13pt;
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 20px;
        text-transform: uppercase;
      }
      .meta-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 13pt;
        page-break-inside: avoid;
      }
      .meta-table td {
        vertical-align: top;
        font-size: 13pt;
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
      .peserta-table thead {
        display: table-header-group;
      }
      .peserta-table tbody {
        display: table-row-group;
      }
      .peserta-table tr {
        page-break-inside: avoid;
      }
      .peserta-table th,
      .peserta-table td {
        border: 1px solid #000;
        padding: 6px;
        font-size: 11pt;
        text-align: left;
        vertical-align: middle;
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
        font-size: 13pt;
        page-break-inside: avoid;
      }
      .content p {
        margin: 0 0 15px 0;
        font-size: 13pt;
      }
      .signature-container {
        margin-top: 40px;
        float: right;
        width: 50%;
        text-align: left;
        font-size: 13pt;
        page-break-inside: avoid;
        page-break-after: avoid;
      }
      .signature-title {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 13pt;
      }
      .signature-name {
        font-weight: bold;
        font-size: 13pt;
      }
      .clearfix::after {
        content: "";
        clear: both;
        display: table;
      }
      .signature-unit {
        padding-left: 29px;
        display: block;
        font-size: 13pt;
      }
      .signature-body {
        font-weight: bold;
        font-size: 13pt;
      }
      .signature-nip {
        margin-top: 5px;
        font-size: 13pt;
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
          padding-top: 0;
          page-break-after: auto;
          page-break-inside: auto;
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
        <td>@php $dari = $suratNodin->dari; $prefix = ''; if (($suratNodin->dari_plt ?? false)) $prefix .= 'Plt. '; if (($suratNodin->dari_an ?? false)) $prefix .= 'a.n. '; echo $prefix . ($dari ?: '-'); @endphp</td>
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

    @php
        $pesertaCount = $suratNodin->pesertaSuratUsulans->count();
        $showPesertaTable = $pesertaCount <= 15;
    @endphp

    @if($showPesertaTable)
    <table class="peserta-table">
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 22%;">Nama</th>
          <th style="width: 18%;">NIP/NIS</th>
          <th style="width: 15%;">Pangkat / Gol</th>
          <th style="width: 15%;">Jabatan</th>
          <th style="width: 25%;">Tanggal/Tempat Kegiatan</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $pesertaList = $suratNodin->pesertaSuratUsulans;
            
            // 1. Urutkan berdasarkan tanggal awal, tanggal akhir, dan tempat kegiatan agar mengelompok
            $sorted = $pesertaList->sortBy(function ($peserta) {
                $awal = ($peserta->tgl_awal_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $peserta->tgl_awal_kegiatan->format('Y-m-d') : ($peserta->tgl_awal_kegiatan ?? '');
                $akhir = ($peserta->tgl_akhir_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $peserta->tgl_akhir_kegiatan->format('Y-m-d') : ($peserta->tgl_akhir_kegiatan ?? '');
                $tempat = $peserta->tempat_kegiatan ?? '';
                return $awal . '|' . $akhir . '|' . $tempat;
            })->values();

            // 2. Hitung jumlah baris (rowspan) untuk setiap kombinasi tanggal dan tempat
            $counts = [];
            foreach ($sorted as $peserta) {
                $awal = ($peserta->tgl_awal_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $peserta->tgl_awal_kegiatan->format('Y-m-d') : ($peserta->tgl_awal_kegiatan ?? '');
                $akhir = ($peserta->tgl_akhir_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? $peserta->tgl_akhir_kegiatan->format('Y-m-d') : ($peserta->tgl_akhir_kegiatan ?? '');
                $tempat = $peserta->tempat_kegiatan ?? '';
                $key = $awal . '|' . $akhir . '|' . $tempat;
                
                $counts[$key] = ($counts[$key] ?? 0) + 1;
            }

            $renderedKeys = [];
        ?>

        @foreach($sorted as $index => $peserta)
            <?php
                $awal = ($peserta->tgl_awal_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? \Carbon\Carbon::parse($peserta->tgl_awal_kegiatan->format('Y-m-d')) : null;
                $akhir = ($peserta->tgl_akhir_kegiatan ?? '') instanceof \Carbon\CarbonInterface ? \Carbon\Carbon::parse($peserta->tgl_akhir_kegiatan->format('Y-m-d')) : null;
                $tempat = $peserta->tempat_kegiatan ?? '';
                
                $keyValAwal = $awal ? $awal->format('Y-m-d') : '';
                $keyValAkhir = $akhir ? $akhir->format('Y-m-d') : '';
                $key = $keyValAwal . '|' . $keyValAkhir . '|' . $tempat;

                if ($awal && $akhir && $awal->isSameDay($akhir)) {
                    $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y');
                } elseif ($awal && $akhir && $awal->format('n') === $akhir->format('n') && $awal->format('Y') === $akhir->format('Y')) {
                    $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d') . ' s.d. ' . \App\Http\Controllers\SuratNodinController::formatTanggal($akhir, '%d %B %Y');
                } elseif ($awal && $akhir) {
                    $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y') . ' s.d. ' . \App\Http\Controllers\SuratNodinController::formatTanggal($akhir, '%d %B %Y');
                } elseif ($awal) {
                    $tanggalText = \App\Http\Controllers\SuratNodinController::formatTanggal($awal, '%d %B %Y');
                } else {
                    $tanggalText = '';
                }
            ?>
            <tr>
              <td style="text-align: center;"><?php echo e($index + 1); ?>.</td>
              <td>
                @if($peserta->pegawai)
                  {{ $peserta->pegawai->nama }}
                @elseif($peserta->siswa)
                  {{ ucwords(strtolower($peserta->siswa->nama)) }}
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
              
              @php
                  $pangkat = $peserta->pegawai->pangkat ?? null;
                  $golongan = $peserta->pegawai->golongan ?? null;
                  $pangkatGolongan = $pangkat || $golongan
                      ? trim(($pangkat ?: '') . ($golongan ? ', ' . $golongan : ''), ', ')
                      : '-';
              @endphp
              
              <td style="text-align: {{ $peserta->siswa || $pangkatGolongan === 'IX' || $pangkatGolongan === '-' ? 'center' : 'left' }};">
                @if($peserta->pegawai)
                  {{ $pangkatGolongan }}
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

              {{-- Hanya kolom tanggal & tempat yang di-rowspan --}}
              @if(!in_array($key, $renderedKeys))
                  <td rowspan="{{ $counts[$key] }}">
                    {{ $tanggalText }} {{ $tempat ?: '-' }}
                  </td>
                  <?php $renderedKeys[] = $key; ?>
              @endif
            </tr>
        @endforeach

        @if($suratNodin->pesertaSuratUsulans->isEmpty())
        <tr>
          <td colspan="6" style="text-align: center;">Tidak ada data peserta.</td>
        </tr>
        @endif

      </tbody>
    </table>
    @endif

    <div class="content">
      <p>Demikian surat permohonan ini kami sampaikan atas perhatian Bapak, Kami ucapkan terima kasih.</p>
    </div>

    <div class="clearfix">
      <div class="signature-container">
        <div class="signature-title">
            @php
                $atasan = $suratNodin->penandatangan;
                $pegawaiTugas = $suratNodin->pegawaiTugas;

                $jabatanAtasan = $atasan->jabatan ?? '';
                $unitKerjaAtasan = $atasan->unit_kerja ?? '';
                $nama = $atasan->nama ?? '';
                $pangkat = $atasan->pangkat_golongan ?? '';
                $nip = $atasan->nip ?? '';

                $jabatanTugas = $pegawaiTugas->jabatan ?? '';
                $unitKerjaTugas = $pegawaiTugas->unit_kerja ?? '';

                $isPlt = $suratNodin->penandatangan_plt ?? false;
                $isAn = $suratNodin->penandatangan_an ?? false;

                if ($isPlt && $isAn) {
                    $isAn = false;
                }

                $prefix = '';
                $indent = false;
                $showTugas = false;
                $unitKerja = '';

                if ($isPlt) {
                    $prefix = 'Plt.' . html_entity_decode('&nbsp;');
                    $indent = true;
                    $showTugas = true;
                    $unitKerja = $unitKerjaTugas ?: $unitKerjaAtasan;
                } elseif ($isAn) {
                    $prefix = 'a.n.' . html_entity_decode('&nbsp;');
                    $indent = true;
                    $showTugas = true;
                    $unitKerja = $unitKerjaAtasan;
                } else {
                    $prefix = '';
                    $indent = false;
                    $showTugas = false;
                    $unitKerja = $unitKerjaAtasan;
                }

                $indentChar = html_entity_decode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
            @endphp
            {{ $prefix . $jabatanAtasan }}
            <br>{{ $indent ? $indentChar . $unitKerja : $unitKerja }}
            <br><br><br>
            @if($showTugas && $jabatanTugas)
                <br>{{ $indentChar . $jabatanTugas }}
            @endif
            <br>{{ $indent ? $indentChar . $nama : $nama }}
            @if($pangkat && $pangkat != '-')
                <br>{{ $indent ? $indentChar . $pangkat : $pangkat }}
            @endif
            <br>{{ $indent ? $indentChar . 'NIP. ' . $nip : 'NIP. ' . $nip }}
        </div>
      </div>
    </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;padding-left:15px">
      <a href="{{ route('surat-nodins.lampiran-tabel-peserta', $suratNodin) }}" target="_blank" style="display:inline-block; margin-right:0.5rem; background:#16a34a; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; font-weight:bold;">Lampiran Tabel Peserta</a>
      <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
      <a href="{{ route('surat-nodins.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
    </div>
  </body>
</html>