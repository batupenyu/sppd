<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Perjalanan Dinas (SPD)</title>
<style>
  @page {
    size: A4;
    margin: 0.5cm 10mm;
  }
  * { box-sizing: border-box; }
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 13px;
    color: #000;
    margin: 0;
    padding: 0;
    background: #e9e9e9;
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
  .page-number {
    text-align: center;
    font-weight: bold;
    margin-bottom: 10px;
  }
  /* ===== Kop Surat (gambar dari database) ===== */
  .kop-surat-container {
    text-align: center;
    margin-bottom: 8px;
  }
  .kop-surat-image {
    max-width: 100%;
    max-height: 110px;
    height: auto;
    display: inline-block;
  }
  .header-line {
    border: none;
    border-top: 3px solid #000;
    margin: 8px 0 18px 0;
  }

  .doc-meta {
    width: 350px;
    margin-left: auto;
    margin-bottom: 18px;
    font-size: 13px;
  }
  .doc-meta table td {
    padding: 1px 4px;
    vertical-align: top;
    white-space: nowrap;
  }
  .doc-meta .label { width: 75px; }
  .dots {
    border-bottom: 1px dotted #000;
    display: inline-block;
    min-width: 180px;
  }

  .title {
    text-align: center;
    font-weight: bold;
    font-size: 14px;
    text-decoration: underline;
    letter-spacing: 1px;
    margin-bottom: 14px;
  }

  table.spd {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-size: 13px;
  }
  table.spd td, table.spd th {
    border: 1px solid #000;
    padding: 4px 6px;
    vertical-align: top;
  }
  table.spd td.num {
    width: 22px;
    text-align: center;
    font-weight: bold;
  }
  table.spd td.desc { width: 40%; }
  table.spd td.sub-letter { width: 31%; text-align: left; }
  .sub-list td { border-top: none; }
  .footnote {
    font-size: 12px;
    margin-top: 6px;
  }
  .signoff {
    text-align: left;
    margin-top: 10px;
    margin-left: auto;
    width: 230px;
    line-height: 1.5;
  }
  .signoff .space { height: 55px; }

  table.travel {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }
  table.travel td {
    border: 1px solid #000;
    padding: 3px 6px;
    vertical-align: top;
  }
  table.travel td.roman { width: 6%; }
  table.travel td.left-cell { width: 47%; }
  table.travel td.right-cell { width: 47%; }
  .field-row { display: flex; margin-bottom: 3px; }
  .field-label { width: 130px; flex-shrink: 0; }
  .field-colon { width: 12px; flex-shrink: 0; }
  .field-dots {
    border-bottom: 1px dotted #000;
    flex-grow: 1;
    min-height: 14px;
  }
  .sign-block { margin-top: 14px; }
  .sign-space { height: 22px; }
  .perhatian {
    font-size: 12.5px;
    line-height: 1.5;
    text-align: justify;
  }
  .perhatian b { text-decoration: underline; }
  .final-signoff {
    text-align: left;
    margin-top: 16px;
    margin-left: auto;
    width: 230px;
    line-height: 1.6;
  }

  @media print {
    body { background: white; }
    .page {
      box-shadow: none;
      margin: 0;
      page-break-after: always;
    }
    .no-print { display: none !important; }
    table.travel td { padding: 2px 5px; }
    .field-row { margin-bottom: 2px; }
    .sign-space { height: 18px; }
    .final-signoff { margin-top: 8px; }
  }
</style>
</head>
<body>

<!-- ============ HALAMAN 3 ============ -->
<div class="page">
  <!-- <div class="page-number">- 3 -</div> -->

  <div class="kop-surat-container">
    @if ($kopSuratBase64)
      <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
    @endif
  </div>

  <!-- <hr class="header-line"> -->

  <div class="doc-meta">
    <table>
      <tr><td class="label">Lembar Ke</td><td>: <span class="dots">{{ $spd->lembar_ke ?: '&nbsp;' }}</span></td></tr>
      <tr><td class="label">Kode No.</td><td>: <span class="dots">{{ $spd->kode_no ?: '&nbsp;' }}</span></td></tr>
      <tr><td class="label">Nomor</td><td>: <span class="dots">{{ $spd->nomor ?: '&nbsp;' }}</span></td></tr>
    </table>
  </div>

  <div class="title">SURAT PERJALANAN DINAS (SPD)</div>

  <table class="spd">
    <tr>
      <td class="num">1.</td>
      <td class="desc">PA/KPA/PPK/Pejabat Berwenang</td>
      <td class="sub-letter">{{ $spd->pejabat_pemberi_tugas ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num">2.</td>
      <td class="desc">Nama/NIP Pegawai yang melaksanakan perjalanan dinas</td>
      <td class="sub-letter">{{ $spd->nama ?: '-' }}<br>NIP. {{ $spd->nip ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num" rowspan="3">3.</td>
      <td class="desc">a.&nbsp; Pangkat dan Golongan</td>
      <td class="sub-letter">a. {{ $spd->pangkat_golongan ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="desc">b.&nbsp; Jabatan/Instansi</td>
      <td class="sub-letter">b. {{ $spd->jabatan_instansi ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="desc">c.&nbsp; Tingkat Biaya Perjalanan Dinas</td>
      <td class="sub-letter">c. {{ $spd->tingkat_biaya ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num">4.</td>
      <td class="desc">Maksud Perjalanan Dinas</td>
      <td class="sub-letter">{{ $spd->maksud_perjalanan ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num">5.</td>
      <td class="desc">Alat angkut yang dipergunakan</td>
      <td class="sub-letter">{{ $spd->alat_angkut ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num" rowspan="2">6.</td>
      <td class="desc">a.&nbsp; Tempat berangkat</td>
      <td class="sub-letter">a. {{ $spd->tempat_berangkat ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="desc">b.&nbsp; Tempat Tujuan</td>
      <td class="sub-letter">b. {{ $spd->tempat_tujuan ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num" rowspan="3">7.</td>
      <td class="desc">a.&nbsp; Lamanya Perjalanan Dinas</td>
      <td class="sub-letter">a. {{ $lamaHuruf ?? '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="desc">b.&nbsp; Tanggal berangkat</td>
      <td class="sub-letter">b. {{ $spd->tanggal_berangkat ? $spd->tanggal_berangkat->format('d-m-Y') : '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="desc">c.&nbsp; Tanggal harus kembali/tiba di tempat baru *)</td>
      <td class="sub-letter">c. {{ $spd->tanggal_kembali ? $spd->tanggal_kembali->format('d-m-Y') : '-' }}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num" rowspan="6">8.</td>
      <td>Pengikut : &nbsp;Nama</td>
      <td>Tanggal Lahir</td>
      <td>Keterangan</td>
    </tr>
    <tr><td>1.</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>2.</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>3.</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>4.</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td>5.</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
      <td class="num" rowspan="2">9.</td>
      <td>Pembebanan Anggaran</td>
      <td class="sub-letter">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Instansi<br>Akun</td>
      <td class="sub-letter"><ol type="a" style="margin:0; padding-left:1.1rem;"><li>{{ $spd->instansi ?: '-' }}</li><li>{{ $spd->akun ?: '-' }}</li></ol></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="num">10.</td>
      <td style="height:50px;">Keterangan lain-lain</td>
      <td class="sub-letter">{{ $spd->keterangan_lain ?: '-' }}</td>
      <td>&nbsp;</td>
    </tr>
  </table>

  <div class="footnote">*)coret yang tidak perlu</div>

  <div class="signoff">
    Dikeluarkan di {{ $spd->dikeluarkan_di ?: '...............' }}<br>
    Tanggal {{ $spd->tanggal_dikeluarkan ? $spd->tanggal_dikeluarkan->format('d-m-Y') : '...........' }}<br>
    PA/KPA/PPK/Pejabat Berwenang<br>
    <div class="space"></div>
    ({{ $spd->pejabat_pemberi_tugas ?: '......................................' }})<br>
    NIP. {{ $spd->nip ?: '' }}
  </div>

  <div class="no-print" style="margin-top:18px; text-align:center;">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak SPD</button>
    <a href="{{ route('spds.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
  </div>
</div>

<!-- ============ HALAMAN 4 ============ -->
<div class="page">
  <!-- <div class="page-number">- 4 -</div> -->

  <table class="travel">
    <tr>
      <td class="roman">I.</td>
      <td class="left-cell">&nbsp;</td>
      <td class="right-cell">
        <div class="field-row">
          <div class="field-label">I. Berangkat dari</div>
          <div class="field-colon">:</div>
          <div class="field-dots">{{ $spd->tempat_berangkat ?: '' }}</div>
        </div>
        <div class="field-row">
          <div class="field-label">(Tempat Kedudukan)</div>
          <div class="field-colon"></div>
          <div class="field-dots" style="border-bottom:none;"></div>
        </div>
        <div class="field-row">
          <div class="field-label">Ke</div>
          <div class="field-colon">:</div>
          <div class="field-dots">{{ $spd->tempat_tujuan ?: '' }}</div>
        </div>
        <div class="field-row">
          <div class="field-label">Pada Tanggal</div>
          <div class="field-colon">:</div>
          <div class="field-dots">{{ $spd->tanggal_berangkat ? $spd->tanggal_berangkat->format('d-m-Y') : '' }}</div>
        </div>
        <div class="field-row">
          <div class="field-label">Kepala</div>
          <div class="field-colon"></div>
          <div class="field-dots" style="border-bottom:none;"></div>
        </div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
    </tr>
    <tr>
      <td class="roman">II.</td>
      <td class="left-cell">
        <div class="field-row"><div class="field-label">Tiba di</div><div class="field-colon">:</div><div class="field-dots">{{ $spd->tempat_tujuan ?: '' }}</div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots">{{ $spd->tanggal_berangkat ? $spd->tanggal_berangkat->format('d-m-Y') : '' }}</div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
      <td class="right-cell">
        <div class="field-row"><div class="field-label">Berangkat dari</div><div class="field-colon">:</div><div class="field-dots">{{ $spd->tempat_tujuan ?: '' }}</div></div>
        <div class="field-row"><div class="field-label">(Tempat Kedudukan)</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="field-row"><div class="field-label">Ke</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
    </tr>

    <tr>
      <td class="roman">III.</td>
      <td class="left-cell">
        <div class="field-row"><div class="field-label">Tiba di</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
      <td class="right-cell">
        <div class="field-row"><div class="field-label">Berangkat dari</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">(Tempat Kedudukan)</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="field-row"><div class="field-label">Ke</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
    </tr>

    <tr>
      <td class="roman">IV.</td>
      <td class="left-cell">
        <div class="field-row"><div class="field-label">Tiba di</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
      <td class="right-cell">
        <div class="field-row"><div class="field-label">Berangkat dari</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">(Tempat Kedudukan)</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="field-row"><div class="field-label">Ke</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
    </tr>

    <tr>
      <td class="roman">V.</td>
      <td class="left-cell">
        <div class="field-row"><div class="field-label">Tiba di</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
      <td class="right-cell">
        <div class="field-row"><div class="field-label">Berangkat dari</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">(Tempat Kedudukan)</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="field-row"><div class="field-label">Ke</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon"></div><div class="field-dots" style="border-bottom:none;"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
    </tr>

    <tr>
      <td class="roman">VI.</td>
      <td class="left-cell">
        <div class="field-row"><div class="field-label">Tiba di</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Pada Tanggal</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="field-row"><div class="field-label">Kepala</div><div class="field-colon">:</div><div class="field-dots"></div></div>
        <div class="sign-space"></div>
        <div>(...............................)</div>
        <div>NIP</div>
      </td>
      <td class="right-cell" style="font-size:12.5px; line-height:1.5;">
        Telah diperiksa, dengan keterangan bahwa perjalanan tersebut diatas benar dilakukan atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya
      </td>
    </tr>

    <tr>
      <td class="roman">VII.</td>
      <td colspan="2">Catatan lain-lain</td>
    </tr>

    <tr>
      <td class="roman">VIII.</td>
      <td colspan="2" class="perhatian">
        <b>PERHATIAN :</b><br>
        Pejabat yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggung jawab berdasarkan peraturan-peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian, dan kealpaannya.
      </td>
    </tr>
  </table>

  <div class="final-signoff">
    PA/KPA/PPK/Pejabat Berwenang,<br>
    <div class="space" style="height:55px;"></div>
    ({{ $spd->pejabat_pemberi_tugas ?: '......................................' }})<br>
    NIP. {{ $spd->nip ?: '' }}
  </div>
</div>

</body>
</html>
