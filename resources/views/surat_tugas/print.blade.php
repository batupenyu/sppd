<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Tugas</title>
<style>
  @page { size: A4; margin: 1cm 20mm; }
  body {
              background-color: #525659;
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    color: #000;
    max-width: 750px;
    margin: 1cm auto;
    padding: 20px 40px;
    line-height: 1;
    text-align: justify;
  }
  .title { text-align: center; margin-bottom: 4px; }
  .title h1 { font-size: 16px; letter-spacing: 1px; margin: 0; }
  .title .nomor { font-size: 14px; margin-top: 4px; }
  /* .dots {
    border-bottom: 1px dotted #000;
    display: inline-block;
    min-width: 20px;
  } */
  table { width: 100%; border-collapse: collapse; margin-top: 10px; }
  td { vertical-align: top; padding: 3px 0; }
  .label { width: 90px; white-space: nowrap; }
  .colon { width: 15px; }
  .field-label { width: 110px; white-space: nowrap; }
  .no-col { width: 25px; vertical-align: top; }
  .memerintahkan { text-align: center; margin: 25px 0; font-weight: normal; }
  /* .fill { border-bottom: 1px dotted #000; display: block; min-height: 20px; } */
  .sub-table td { padding: 2px 0; }
  .peserta-sep { height: 12px; }
  .dasar-list { margin: 2px 0; padding-left: 22px; }
  .dasar-list li { margin: 2px 0; }
  .signature { margin-top: 60px; margin-left: 340px; }
  .signature .line { margin-bottom: 4px; }
  .signature .spacer { height: 60px; }
  .no-print { margin-top: 20px; text-align: center; }
  .kop-surat-container { text-align: center; margin-bottom: 8px; }
  .kop-surat-image { max-width: 100%; max-height: 110px; height: auto; display: inline-block; }
  .doc-meta { margin: 10px 0; }
  .doc-meta table td { padding: 2px 0; }
  .doc-meta .label { width: 75px; white-space: nowrap; }
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
    body { margin: 0; padding: 1cm 40px; background: white; }
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

  <div class="page">
  <div class="kop-surat-container">
    @if ($kopSuratBase64)
      <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
    @endif
  </div>

  <div class="title">
    <h1>SURAT TUGAS</h1>
    <div class="nomor">NOMOR : {{ $suratTugas->nomor ?: ' ' }}</div>
  </div>

  <table>
    <tr>
      <td class="label" style="vertical-align: top; padding-top: 3px;">Dasar</td>
      <td class="colon" style="vertical-align: top; padding-top: 3px;">:</td>
      <td>
        @php
          $dasarItems = array_filter(array_map('trim', explode("\n", $suratTugas->dasar ?: '')), fn ($l) => $l !== '');
        @endphp
        @if (count($dasarItems))
          <ol class="dasar-list">
            @foreach ($dasarItems as $item)
              <li>{{ $item }}</li>
            @endforeach
          </ol>
        @else
          <span class="fill">&nbsp;</span>
        @endif
      </td>
    </tr>
  </table>

  <div class="memerintahkan">MEMERINTAHKAN:</div>

  <table>
    <tr>
      <td class="label" style="vertical-align:top; width:80px;padding: 14px 0;">Kepada</td>
      <td class="colon" style="vertical-align:top;padding-top :14px;">:</td>
      <td>
        <table class="sub-table">
          @forelse ($peserta as $i => $p)
            <tr>
              <td class="no-col">{{ $i + 1 }}.</td>
              <td class="field-label">Nama</td>
              <td class="colon">:</td>
              <td><span class="fill">{{ $p->nama ?: ' ' }}</span></td>
            </tr>
            <tr>
              <td></td>
              <td class="field-label">Pangkat/gol</td>
              <td class="colon">:</td>
              <td><span class="fill">{{ $p->pangkat_golongan ?: ' ' }}</span></td>
            </tr>
            <tr>
              <td></td>
              <td class="field-label">NIP</td>
              <td class="colon">:</td>
              <td><span class="fill">{{ $p->nip ?: ' ' }}</span></td>
            </tr>
            <tr>
              <td></td>
              <td class="field-label">Jabatan</td>
              <td class="colon">:</td>
              <td><span class="fill">{{ $p->tugas_tambahan ?: ' ' }}</span></td>
            </tr>
            @if (!$loop->last)
              <tr><td colspan="4" class="peserta-sep"></td></tr>
            @endif
          @empty
            <tr>
              <td class="no-col">1.</td>
              <td class="field-label">Nama</td>
              <td class="colon">:</td>
              <td><span class="fill">&nbsp;</span></td>
            </tr>
            <tr>
              <td></td>
              <td class="field-label">Pangkat/gol</td>
              <td class="colon">:</td>
              <td><span class="fill">&nbsp;</span></td>
            </tr>
            <tr>
              <td></td>
              <td class="field-label">NIP</td>
              <td class="colon">:</td>
              <td><span class="fill">&nbsp;</span></td>
            </tr>
            <tr>
              <td></td>
              <td class="field-label">Jabatan</td>
              <td class="colon">:</td>
              <td><span class="fill">&nbsp;</span></td>
            </tr>
          @endforelse
        </table>
      </td>
    </tr>
  </table>

  <table style="margin-top:25px;">
    <tr class="untuk-row">
      <td class="label" style="vertical-align:top; padding-top: 14px;">Untuk</td>
      <td class="colon" style="vertical-align:top; padding-top: 14px;">:</td>
      <td>
        <table class="sub-table">
          <tr>
            <td class="no-col">1.</td>
            <td><span class="fill">{{ $suratTugas->untuk_1 ?: ' ' }}</span></td>
          </tr>
          <tr>
            <td class="no-col">2.</td>
            <td><span class="fill">{{ $suratTugas->untuk_2 ?: ' ' }}</span></td>
          </tr>
          <tr>
            <td class="no-col">3.</td>
            <td><span class="fill">{{ $suratTugas->untuk_3 ?: ' ' }}</span></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <div class="signature">
    <div class="line">{{ $suratTugas->dikeluarkan_di ?: 'Nama Tempat' }}, {{ $suratTugas->tanggal_dikeluarkan ? $suratTugas->tanggal_dikeluarkan->format('d F Y') : 'Tanggal' }}<br>
    {{ $suratTugas->jabatan_penandatangan ?: 'Gubernur' }}
    </div>
    <div class="spacer"></div>
    <!-- <div class="line">{{ $suratTugas->jabatan_penandatangan ?: 'Gubernur' }}</div> -->
    <!-- <div class="line">Kepulauan Bangka Belitung,</div> -->
    <!-- <div class="spacer"></div> -->
    <div class="line">{{ $suratTugas->nama_penandatangan ?: 'Nama' }}<br>
    NIP.{{ $suratTugas->nip_penandatangan ?: 'NIP' }}
    </div>
  </div>

  <div class="no-print">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-tugas.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
  </div>
  </div>

</body>
</html>
