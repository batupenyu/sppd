<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Berkas Penarikan Siswa - Status Mengundurkan Diri</title>
<style>
  @page { size: A4; margin: 2.5cm 2.5cm; }
  * { box-sizing: border-box; }
  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    line-height: 1.5;
    color: #111;
    background: #e9e9e9;
    margin: 0;
    padding: 0;
  }
  .page {
    background: #fff;
    max-width: 800px;
    margin: 24px auto;
    padding: 60px 70px;
    box-shadow: 0 0 12px rgba(0,0,0,0.15);
    position: relative;
  }
  .kop {
    text-align: center;
    border-bottom: 3px double #000;
    padding-bottom: 10px;
    margin-bottom: 24px;
  }
  .kop .kop-label {
    font-size: 10pt;
    letter-spacing: 2px;
    color: #888;
    border: 1px dashed #bbb;
    display: inline-block;
    padding: 4px 12px;
  }
  .doc-title {
    text-align: center;
    font-weight: bold;
    text-decoration: underline;
    font-size: 13pt;
    margin: 4px 0 2px;
    text-transform: uppercase;
  }
  .doc-number {
    text-align: center;
    margin-bottom: 18px;
  }
  .meta-table {
    margin: 10px 0 16px;
    border-collapse: collapse;
  }
  .meta-table td {
    vertical-align: top;
    padding: 1px 4px;
  }
  .meta-table td.label { white-space: nowrap; }
  .meta-table td.colon { padding: 0 4px; }
  .data-table {
    margin: 14px 0;
    border-collapse: collapse;
  }
  .data-table td {
    padding: 2px 0px;
    vertical-align: top;
  }
  .data-table td.label {
    width: 190px;
    white-space: nowrap;
  }
  .data-table td.colon {
    width: 14px;
  }
  p { margin: 0 0 14px; text-align: justify; }
  .indent { text-indent: 40px; }
  .signature-block {
    margin-top: 40px;
    width: 320px;
    margin-left: auto;
    text-align: center;
  }
  .signature-block .place-date { margin-bottom: 4px; }
  .signature-space { height: 70px; }
  .signature-name {
    font-weight: bold;
    text-decoration: underline;
  }
  .stamp-note {
    font-style: italic;
    color: #666;
    font-size: 10.5pt;
  }
  .placeholder {
    color: #a6001f;
    font-style: italic;
  }
  .sign-columns {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
  }
  .sign-columns .col {
    width: 45%;
    text-align: center;
  }
  .sign-columns .signature-space {
    height: 60px;
  }
  .divider {
    text-align: center;
    margin: 40px 0;
    color: #bbb;
    font-size: 11pt;
    letter-spacing: 3px;
  }
  .toolbar {
    max-width: 800px;
    margin: 20px auto 0;
    text-align: right;
  }
  .toolbar button {
    font-family: Arial, sans-serif;
    font-size: 11pt;
    padding: 8px 18px;
    border: none;
    border-radius: 6px;
    background: #2563eb;
    color: #fff;
    cursor: pointer;
  }
  .toolbar button:hover { background: #1d4ed8; }
  @media print {
    body { background: #fff; }
    .toolbar { display: none; }
    .page {
      box-shadow: none;
      margin: 0;
      padding: 0;
      max-width: none;
      page-break-after: always;
    }
  }
</style>
</head>
<body>

<div class="toolbar">
  <button onclick="window.print()">Cetak / Simpan sebagai PDF</button>
</div>

@php
  $fmt = fn ($d) => $d ? \App\Http\Controllers\SuratPenarikanSiswaController::formatTanggal($d, '%d %B %Y') : '...................';
  $s = $suratPenarikanSiswa;
  $penandatangan = $s->penandatangan;
  $pegawai = $s->pegawai;
@endphp

<!-- ================= DOKUMEN 1: SURAT PERMOHONAN SEKOLAH ================= -->
<div class="page">
  <div class="kop"><span class="kop-label">KOP SURAT SEKOLAH</span></div>

  <table class="meta-table">
    <tr><td colspan="3" style="text-align:right;">{{ $s->nama_kota_sekolah ?? '...................' }}, {{ $fmt($s->tanggal_surat) }}</td></tr>
    <tr>
      <td class="label">Nomor</td><td class="colon">:</td>
      <td>{{ $s->nomor_surat ?: '...................' }}</td>
    </tr>
    <tr>
      <td class="label">Lampiran</td><td class="colon">:</td>
      <td>1 (satu) Berkas</td>
    </tr>
    <tr>
      <td class="label">Hal</td><td class="colon">:</td>
      <td><strong>Permohonan Penarikan Siswa Status Mengundurkan Diri</strong></td>
    </tr>
  </table>

  <p style="margin-top:20px;">
    Yth. Kepala Dinas Pendidikan Provinsi / Kabupaten {{ $s->nama_wilayah_cabdinas ?: '...................' }}<br>
    c.q. Kepala Cabang Dinas Pendidikan Wilayah {{ $s->nama_wilayah_cabdinas ?: '...................' }}<br>
    di -<br>
    {{ $s->nama_kota_cabdin ?: '...................' }}
  </p>

  <p class="indent">
    Yang bertanda tangan di bawah ini, Kepala {{ $s->nama_sekolah_asal ?: '...................' }}, dengan ini
    mengajukan permohonan pembatalan/penarikan status &ldquo;Mengundurkan Diri&rdquo; pada
    Data Pokok Pendidikan (Dapodik) untuk siswa kami berikut ini:
  </p>

  <table class="data-table">
    <tr><td class="label">Nama Siswa</td><td class="colon">:</td><td>{{ $s->nama_siswa ?: '...................' }}</td></tr>
    <tr><td class="label">NIS / NISN</td><td class="colon">:</td><td>{{ $s->nis ?: '...................' }} / {{ $s->nisn ?: '...................' }}</td></tr>
    <tr><td class="label">Kelas/Jurusan</td><td class="colon">:</td><td>{{ $s->kelas_jurusan ?: '...................' }}</td></tr>
    <tr><td class="label">Nama Orang Tua/Wali</td><td class="colon">:</td><td>{{ $s->nama_orang_tua ?: '...................' }}</td></tr>
  </table>

  <p class="indent">
    Siswa tersebut di atas sebelumnya dinyatakan mengundurkan diri berdasarkan
    {{ $s->alasan ?: '...................' }}. Namun, saat ini siswa
    yang bersangkutan menyatakan komitmen kuat untuk kembali bersekolah dan
    melanjutkan pendidikannya di {{ $s->nama_sekolah_tujuan ?: '...................' }}.
  </p>

  <p class="indent">
    Guna menunjang kelancaran proses administrasi mutasi dan pemulihan data
    siswa pada Dapodik di sekolah tujuan, kami memohon bantuan Bapak/Ibu untuk
    menyetujui dan memproses penarikan status tersebut. Sebagai bahan pertimbangan,
    bersama ini kami lampirkan surat pernyataan dari orang tua dan siswa.
  </p>

  <p class="indent">
    Demikian surat permohonan ini kami sampaikan. Atas perhatian, bantuan, dan
    kerja sama Bapak/Ibu, kami ucapkan terima kasih.
  </p>

  <div class="signature-block">
    <div class="place-date">{{ $s->nama_kota_sekolah ?? '...................' }}, {{ $fmt($s->tanggal_surat) }}</div>
    <div>Kepala {{ $s->nama_sekolah_asal ?: '...................' }},</div>
    <div class="signature-space"></div>
    <div class="stamp-note">(Stempel Resmi Sekolah)</div>
    <div class="signature-name">{{ $pegawai->nama ?: '...................' }}</div>
    <div>NIP. {{ $pegawai->nip ?: '...................' }}</div>
  </div>
</div>

<!-- ================= DOKUMEN 2: SURAT REKOMENDASI CABDIN ================= -->
<div class="page">
  <div class="kop"><span class="kop-label">KOP CABANG DINAS PENDIDIKAN</span></div>

  <div class="doc-title">Surat Rekomendasi</div>
  <div class="doc-number">Nomor: {{ $s->nomor_surat_cabdin ?: '...................' }}</div>

  <p class="indent">
    Berdasarkan Surat Permohonan dari Kepala {{ $s->nama_sekolah_asal ?: '...................' }} Nomor:
    {{ $s->nomor_surat ?: '...................' }} tanggal {{ $fmt($s->tanggal_surat) }} perihal
    Permohonan Penarikan Siswa Status Mengundurkan Diri, Kepala Cabang Dinas
    Pendidikan Wilayah {{ $s->nama_wilayah_cabdinas ?: '...................' }} memberikan rekomendasi kepada:
  </p>

  <table class="data-table">
    <tr><td class="label">Nama Siswa</td><td class="colon">:</td><td>{{ $s->nama_siswa ?: '...................' }}</td></tr>
    <tr><td class="label">NIS / NISN</td><td class="colon">:</td><td>{{ $s->nis ?: '...................' }} / {{ $s->nisn ?: '...................' }}</td></tr>
    <tr><td class="label">Sekolah Asal</td><td class="colon">:</td><td>{{ $s->nama_sekolah_asal ?: '...................' }}</td></tr>
    <tr><td class="label">Sekolah Tujuan</td><td class="colon">:</td><td>{{ $s->nama_sekolah_tujuan ?: '...................' }}</td></tr>
  </table>

  <p class="indent">
    Untuk melakukan Penarikan Siswa dengan Status Kembali Bersekolah pada
    sistem Data Pokok Pendidikan (Dapodik) demi menjamin hak anak dalam
    memperoleh akses pendidikan yang berkelanjutan.
  </p>

  <p class="indent">
    Rekomendasi ini diberikan dengan ketentuan bahwa pihak sekolah tujuan wajib
    mengawal proses pemulihan data siswa yang bersangkutan sesuai dengan regulasi
    pemutakhiran data Dapodik yang berlaku, serta memastikan siswa mendapatkan hak
    pembelajarannya kembali.
  </p>

  <p class="indent">
    Demikian Surat Rekomendasi ini dibuat untuk dapat dipergunakan
    sebagaimana mestinya dan penuh tanggung jawab.
  </p>

  <div class="signature-block">
    <div class="place-date">{{ $s->nama_kota_cabdin ?? '...................' }}, {{ $fmt($s->tanggal_ditetapkan) }}</div>
    <div>Kepala Cabang Dinas Pendidikan Wilayah<br>{{ $s->nama_wilayah_cabdinas ?: '...................' }},</div>
    <div class="signature-space"></div>
    <div class="stamp-note">(Stempel Resmi Cabdin)</div>
    <div class="signature-name">{{ $penandatangan->nama ?: '...................' }}</div>
    <div>NIP. {{ $penandatangan->nip ?: '...................' }}</div>
  </div>
</div>

<!-- ================= DOKUMEN 3: SURAT PERNYATAAN ORANG TUA & SISWA ================= -->
<div class="page">
  <div class="doc-title">Surat Pernyataan <br>
  Kesanggupan Melanjutkan Pendidikan
  </div>
  <div class="doc-number" style="font-weight:bold;"></div>

  <p style="margin-top:20px;">Yang bertanda tangan di bawah ini:</p>

  <p style="font-weight:bold; margin-bottom:6px;">I. DATA ORANG TUA / WALI</p>
  <table class="data-table">
    <tr><td class="label">Nama Orang Tua/Wali</td><td class="colon">:</td><td>{{ $s->nama_orang_tua ?: '...................' }}</td></tr>
    <tr><td class="label">Pekerjaan</td><td class="colon">:</td><td>{{ $s->pekerjaan_orang_tua ?: '...................' }}</td></tr>
    <tr><td class="label">Alamat Rumah</td><td class="colon">:</td><td>{{ $s->alamat_rumah ?: '...................' }}</td></tr>
    <tr><td class="label">No. HP/Telepon</td><td class="colon">:</td><td>{{ $s->no_hp ?: '...................' }}</td></tr>
  </table>

  <p style="font-weight:bold; margin:16px 0 6px;">II. DATA SISWA</p>
  <table class="data-table">
    <tr><td class="label">Nama Siswa</td><td class="colon">:</td><td>{{ $s->nama_siswa ?: '...................' }}</td></tr>
    <tr><td class="label">NISN</td><td class="colon">:</td><td>{{ $s->nisn ?: '...................' }}</td></tr>
    <tr><td class="label">Tempat, Tanggal Lahir</td><td class="colon">:</td><td>{{ $s->tempat_tanggal_lahir ?: '...................' }}</td></tr>
    <tr><td class="label">Sekolah Tujuan</td><td class="colon">:</td><td>{{ $s->nama_sekolah_tujuan ?: '...................' }}</td></tr>
  </table>

  <p class="indent" style="margin-top:16px;">
    Dengan ini kami selaku orang tua/wali dan siswa menyatakan dengan sebenar-benarnya
    dan penuh kesadaran bahwa:
  </p>

  <ol style="text-align:justify; margin:0 0 14px; padding-left:22px;">
    <li style="margin-bottom:8px;">Siswa yang bersangkutan bersedia ditarik kembali datanya dari status
      mengundurkan diri untuk aktif kembali menjadi peserta didik.</li>
    <li style="margin-bottom:8px;">Kami berkomitmen penuh dan bersungguh-sungguh bahwa siswa tersebut akan
      mengikuti seluruh proses pembelajaran di {{ $s->nama_sekolah_tujuan ?: '...................' }} dengan tertib,
      menaati aturan sekolah, dan belajar dengan giat sampai lulus.</li>
    <li>Kami selaku orang tua/wali akan memberikan dukungan penuh, baik moral
      maupun material, serta mengawasi perkembangan belajar anak kami agar tidak
      putus sekolah lagi.</li>
  </ol>

  <p class="indent">
    Demikian surat pernyataan ini kami buat dengan jujur tanpa ada paksaan dari
    pihak mana pun. Apabila di kemudian hari kami melanggar pernyataan ini, kami siap
    menerima sanksi sesuai dengan aturan yang berlaku di sekolah.
  </p>

  <div style="text-align:right; margin-top:20px;">
    </div>
    
    <div style="text-align:center; font-weight:bold; margin-top:5px;">Mengetahui/Menyetujui,</div>
    
    <div class="sign-columns">
      <div class="col">
        <br>
        <div>Siswa yang Menyatakan</div>
        <br>
        <div class="signature-space"></div>
        <div class="signature-name">{{ $s->nama_siswa ?: '...................' }}</div>
      </div>
      <div class="col">
        {{ $s->nama_kota_sekolah ?? '...................' }}, {{ $fmt($s->tanggal_surat) }}
      <div>Orang Tua / Wali</div>
      <div class="signature-space"></div>
      <div class="stamp-note">(Tempel Meterai Rp10.000 &amp; Tanda Tangan)</div>
      <div class="signature-name">{{ $s->nama_orang_tua ?: '...................' }}</div>
    </div>
  </div>
</div>

</body>
</html>
