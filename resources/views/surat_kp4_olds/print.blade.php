<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Keterangan Tunjangan Keluarga - {{ $pegawai->nama ?? '' }}</title>
<style>
  /* =========================================================
     PENTING (khusus DomPDF):
     Kita definisikan 2 "named page":
       - @page (default)   -> A4 potrait, dipakai Halaman 1
       - @page landscape   -> A4 landscape, dipakai Halaman 2
     Elemen yang diberi CSS "page: landscape;" akan otomatis
     dirender memakai ukuran/orientasi halaman "landscape"
     tersebut oleh DomPDF (CSS3 Paged Media).
     ========================================================= */
  @page {
    size: A4 portrait;
    margin: 5mm;
  }
  @page :first {
    size: A4 portrait;
    margin: 5mm;
  }
  @page landscape {
    size: A4 landscape;
    margin: 5mm;
  }

  * { box-sizing: border-box; }
  body {
    font-family: Arial, sans-serif;
    font-size: 16pt;
    color: #111;
    margin: 0;
    padding: 0;
    background: #fff;
  }

  /* ---------- HALAMAN 1 (potrait) ---------- */
  .container {
    max-width: 210mm;
    margin: 0 auto;
    padding: 0 10mm;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  }
  .kop-surat-image { max-width: 100%; max-height: 180px; height: auto; display: inline-block; }

  .title { text-align: center; margin: 4px 0 6px; }
  .title h3 { margin: 1px 0; font-size: 12px; text-decoration: underline; }

  table.fields {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 4px;
  }
  table.fields td {
    padding: 1px 2px;
    vertical-align: top;
    font-size: 10.5pt;
    line-height: 1.25;
  }
  table.fields td.no { width: 18px; }
  table.fields td.label { width: 180px; }
  table.fields td.colon { width: 12px; }

  .keterangan-block { margin: 4px 0 2px; font-size: 10.5pt; line-height: 1.25; }
  .keterangan-block p { margin: 1px 0; }
  .keterangan-block .indent { margin-left: -26px; }
  .keterangan-block .indent2 { margin-left: -26px; }

  table.tanggungan {
    width: 100%;
    border-collapse: collapse;
    margin: 2px 0 4px;
    font-size: 9.5pt;
  }
  table.tanggungan th, table.tanggungan td {
    border: 1px solid #000;
    padding: 2px 3px;
    text-align: center;
  }
  table.tanggungan th { background: #f2f2f2; }

  .footer-note {
    font-size: 9.5pt;
    text-align: justify;
    margin: 4px 0 6px;
    line-height: 1.25;
  }

  .signatures {
    display: flex;
    justify-content: space-between;
    margin-top: 4px;
    font-size: 10.5pt;
    line-height: 1.25;
  }
  .sign-left { width: 45%; text-align: center; }
  .sign-right { width: 45%; text-align: center; margin-left: auto; }
  .sign-right .place-date { text-align: right; margin-bottom: 1px; margin-right: 10px;}
  .sign-space { height: 20px; }
  .sign-name { font-weight: normal; margin-top: 1px; }

  ul.roman-upper { list-style-type: upper-roman; }

  /* ---------- HALAMAN 2 (landscape) ---------- */
  .page-break {
    page-break-before: always;   /* mulai halaman baru */
    page: landscape;             /* pakai named-page "landscape" di atas */
    margin-top: 20px;
  }
  .page2-container {
    max-width: 287mm;   /* lebar A4 landscape dikurangi margin */
    margin: 0 auto;
  }
  .page2-table {
    width: 100%;
    border-collapse: collapse;
    margin: 8px 0 14px;
    font-size: 10px;
    table-layout: fixed;
  }
  .page2-table th, .page2-table td {
    border: 1px solid #000;
    padding: 4px 3px;
    text-align: center;
    word-wrap: break-word;
  }
  .page2-table th { background: #bbbdbf; }
  .page2-table .text-left { text-align: left !important; }
  .mt-5 { margin-top: 20px; }

  @media print {
    body { margin: 0; }
    .no-print { display: none !important; }
    .container, .page2-container { box-shadow: none; }
  }
</style>
</head>
<body>

@php
    $fmt = fn ($d) => $d ? \App\Http\Controllers\SuratKp4OldController::formatTanggal($d, '%d %B %Y') : '';
    $pegawai = $suratKp4Old->pegawai;
    $penandatangan = $suratKp4Old->penandatangan;
    $golongan = $pegawai->golongan ?? '';
    $pangkat = $pegawai->pangkat ?? '';
    $namaAyah = $pegawai && $pegawai->jk === 'L' ? $pegawai->nama : ($pegawai->nama_suami_istri ?? '-');
    $namaIbu = $pegawai && $pegawai->jk === 'L' ? ($pegawai->nama_suami_istri ?? '-') : $pegawai->nama;
    $anakKategori1 = $suratKp4Old->anak->where('kat', 1);
    $anakKategori2 = $suratKp4Old->anak->where('kat', 2);
    $totalAnak1 = $anakKategori1->count();
    $totalAnak2 = $anakKategori2->count();
    $jk = $pegawai->jk === 'L' ? 'Laki-Laki' : ($pegawai->jk === 'P' ? 'Perempuan' : '-');
@endphp

<!-- ======================= HALAMAN 1 (POTRAIT) ======================= -->
<div class="container" id="page1-content">
  <div class="kop-surat-container">
    @if($kopSuratBase64)
      <img src="{{ $kopSuratBase64 }}" alt="Kop Surat" class="kop-surat-image">
    @endif
  </div>

  <div class="title">
    <h3>SURAT KETERANGAN</h3>
    <h3>UNTUK MENDAPATKAN PEMBAYARAN TUNJANGAN KELUARGA</h3>
  </div>

  <table class="fields">
    <tr>
      <td class="no">1.</td>
      <td class="label">Nama Lengkap</td>
      <td class="colon">:</td>
      <td><strong>{{ $pegawai->nama ?? '' }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ ($pegawai->status_kepegawaian ?? '') === 'PNS' ? 'NIP' : 'NIPPPK' }}. {{ $pegawai->nip ?? '' }}</td>
    </tr>
    <tr>
      <td class="no">2.</td>
      <td class="label">Tempat / Tanggal Lahir</td>
      <td class="colon">:</td>
      <td>{{ ($pegawai->tempat_lahir ?? '') }}{{ $pegawai && $pegawai->tanggal_lahir ? ', ' . $fmt($pegawai->tanggal_lahir) : '' }}</td>
    </tr>
    <tr>
      <td class="no">3.</td>
      <td class="label">Jenis Kelamin</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->jk === 'L' ? 'Laki-laki' : ($pegawai->jk === 'P' ? 'Perempuan' : ($pegawai->jk ?? '-')) }}</td>
    </tr>
    <tr>
      <td class="no">4.</td>
      <td class="label">Agama</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->agama ?? '' }}</td>
    </tr>
    <tr>
      <td class="no">5.</td>
      <td class="label">Kebangsaan</td>
      <td class="colon">:</td>
      <td>Indonesia</td>
    </tr>
@php($status = $suratKp4Old->status_kepegawaian ?? ($pegawai->status_kepegawaian ?? ''))
    <tr>
      <td class="no">6.</td>
      <td class="label">Golongan / Status<br>Kepegawaian</td>
      <td class="colon">:</td>
      <td>{{ $pangkat }}&nbsp;/ @if($status == 'PPPK')Pegawai Pemerintah dengan Perjanjian Kerja (PPPK). @else{{ $status }}@endif</td>
    </tr>
    <tr>
      <td class="no">7.</td>
      <td class="label">Jabatan Struktural/Fungsional</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->jabatan ?? '' }}</td>
    </tr>
    <tr>
      <td class="no">8.</td>
      <td class="label">Pada Instansi, Dept. Lembaga</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->unit_kerja ?? '' }}</td>
    </tr>
    <tr>
      <td class="no">9.</td>
      <td class="label">Masa Kerja Golongan</td>
      <td class="colon">:</td>
      <td>{{ $suratKp4Old->masa_kerja_golongan ?? '.....Tahun .....Bulan, Masa Kerja Tambahan .....Tahun .....Bulan, Masa Kerja Seluruhnya .....Tahun .....Bulan' }}</td>
    </tr>
    <tr>
      <td class="no">10.</td>
      <td class="label">Digaji menurut</td>
      <td class="colon">:</td>
      <td>{{ $suratKp4Old->digaji_menurput ?? 'PP Nomor 05 Tahun 2024 (CPNS dan PNS), Perpres Nomor 11 Tahun 2024 (PPPK)' }}</td>
    </tr>
    <tr>
      <td class="no"></td>
      <td class="label">Alamat / Tempat Tinggal</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->alamat_jalan ?? '' }}{{ $pegawai->nama_dusun ? ' Dusun ' . $pegawai->nama_dusun : '' }}{{ $pegawai->desa_kelurahan ? ' ' . $pegawai->desa_kelurahan : '' }}{{ $pegawai->kecamatan ? ' Kec. ' . $pegawai->kecamatan : '' }}</td>
    </tr>
  </table>

  <div class="keterangan-block">
    <p>Menerangkan dengan sesungguhnya bahwa saya :</p>
    <ol type="a" style="margin-left: -26px;text-align: justify;">
      <li>Disamping Jabatan Utama tersebut, bekerja pula sebagai :
        <p style="margin-left: 0px;">dengan mendapat penghasilan sebesar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp&nbsp;&nbsp;&nbsp;{{ $suratKp4Old->penghasilan_disamping ?? '-' }}&nbsp; sebulan</p>
      </li>
      <li>Mempunyai Pensiun / Pensiun Janda&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp&nbsp;&nbsp;&nbsp;{{ $suratKp4Old->pensiun_janda ?? '-' }}&nbsp; sebulan</li>
      <li>Kawin sah dengan :</li>
    </ol>
  </div>

  <table class="tanggungan">
    <thead>
      <tr>
        <th rowspan="2">No.</th>
        <th rowspan="2">Nama Istri / Suami<br>Tanggungan</th>
        <th colspan="2">Tanggal</th>
        <th rowspan="2">Pekerjaan</th>
        <th rowspan="2">Penghasilan<br>Sebulan</th>
        <th rowspan="2">Keterangan</th>
      </tr>
      <tr>
        <th>Kelahiran</th>
        <th>Perkawinan</th>
      </tr>
    </thead>
    <tbody>
      @forelse($suratKp4Old->anggotaKeluarga as $index => $anggota)
      <tr>
        <td>{{ $index + 1 }}.</td>
        <td class="text-left">{{ $anggota->nama }}</td>
        <td>{{ $anggota->tanggal_kelahiran ? $anggota->tanggal_kelahiran->format('d/m/Y') : '-' }}</td>
        <td>{{ $anggota->tanggal_perkawinan ? $anggota->tanggal_perkawinan->format('d/m/Y') : '-' }}</td>
        <td>{{ $anggota->pekerjaan ?? '-' }}</td>
        <td>{{ $anggota->penghasilan_sebulan ? 'Rp ' . $anggota->penghasilan_sebulan : '-' }}</td>
        <td>{{ $anggota->keterangan ?? '-' }}</td>
      </tr>
      @empty
      <tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="keterangan-block">
    <ol type="a" start="4" style="margin-left: -26px;text-align: justify;">
      <li>Mempunyai anak &ndash; anak seperti dalam daftar sebelah ini, yaitu :
        <ul class="roman-upper" style="margin-left: -26px;text-align: justify;">
          <li><strong>Anak Kandung (Ak), Anak Tiri (At)</strong> yang masih menjadi tanggungan, belum mempunyai pekerjaan sendiri dan masuk dalam daftar Gaji.</li>
          <li><strong>Anak Kandung (Ak), Anak Tiri (At), Anak Angkat (Aa)</strong> yang masih menjadi tanggungan, tetapi tidak termasuk dalam daftar Gaji.</li>
        </ul>
      </li>
      <li>Jumlah anak seluruh ( {{ $suratKp4Old->anak->count() ?? 0 }} Orang ) yang menjadi tanggungan termasuk yang tidak termasuk dalam daftar gaji.</li>
    </ol>
  </div>

  <p class="footer-note">
    Keterangan ini saya buat dengan sesungguhnya dan apabila keterangan ini ternyata tidak benar / palsu, saya bersedia dituntut dimuka Pengadilan
    berdasarkan undang-undang yang berlaku, dan bersedia mengembalikan semua uang tunjangan anak yang telah saya terima yang seharusnya
    bukan menjadi hak saya.
  </p>

  <div class="signatures">
    <div class="sign-left">
      <p>Mengetahui:<br>{{ $penandatangan ? ($penandatangan->tugas_tambahan ?: ($penandatangan->jabatan ?: 'Kepala')) : 'Kepala' }} {{ $penandatangan->unit_kerja ?? '' }}</p>
      <div class="sign-space"></div>
      <br>
      <p class="sign-name">{{ $penandatangan->nama ?? '' }}{!! ($penandatangan->status_kepegawaian ?? '') !== 'PPPK' ? '<br>' . e(($penandatangan->pangkat ?? '') . ($penandatangan->golongan ? ' / ' . $penandatangan->golongan : '')) : '' !!}<br>NIP. {{ $penandatangan->nip ?? '' }}</p>
    </div>
    <div class="sign-right">
      <p>{{ $suratKp4Old->tempat_ditetapkan ?? '' }}, {{ $fmt($suratKp4Old->tanggal_ditetapkan ?? null) }}</p>
      <p>Yang Menerangkan,</p>
      <div class="sign-space"></div>
      {!! ($suratKp4Old->status_kepegawaian ?? '') == 'PPPK' ? '<br>' : '' !!}
      <p class="sign-name">{{ $pegawai->nama ?? '' }}{!! ($suratKp4Old->status_kepegawaian ?? '') !== 'PPPK' ? '<br>' . e(($pegawai->pangkat ?? '') . ($pegawai->golongan ? ' / ' . $pegawai->golongan : '')) : '' !!}<br>{!! ($suratKp4Old->status_kepegawaian ?? '') == 'PPPK' ? 'NIPPPK' : 'NIP' !!}. {{ $pegawai->nip ?? '' }}</p>
    </div>
  </div>
</div>

<!-- ======================= HALAMAN 2 (LANDSCAPE) ======================= -->
<div class="page-break page2-container" id="page2-content">

  <p class="mt-5" style="font-size: 14px;">I. Anak Kandung ( Ak ), Anak Tiri ( At ) dan Anak Angkat ( Aa ) yang masih menjadi tanggungan, belum mempunyai penghasilan sendiri dan masuk daftar gaji</p>
  <table class="page2-table">
    <?php $no = 1; ?>
    <tr>
      <th rowspan="2">No.</th>
      <th rowspan="2">Nama</th>
      <th rowspan="2">Status<br>Anak (ak)<br>(at) (aa)</th>
      <th rowspan="2">Tanggal Lahir</th>
      <th rowspan="2">Belum<br>Pernah<br>Kawin</th>
      <th rowspan="2">Bersekolah/<br>Kuliah pada</th>
      <th rowspan="2">Tidak mendapat<br>1. Beasiswa/ darmasiswa<br>2. Ikatan Dinas</th>
      <th colspan="2">Lahir dari Perkawinan</th>
      <th rowspan="2">Tanggal Meninggal/<br>diceraikannya<br>ayah/ibu</th>
      <th rowspan="2">Keterangan<br>diangkat menurut :<br>a. Putusan pengadilan<br>b. Hukum adopsi bagi<br>keturunan Cina</th>
    </tr>
    <tr>
      <th>Nama Ayah</th>
      <th>Nama Ibu</th>
    </tr>
    @if ($totalAnak1 == 0)
      <tr>
        <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
      </tr>
    @endif
    @foreach ($anakKategori1 as $item)
      <tr>
        <td><?php echo $no++; ?>.</td>
        <td class="text-left">{{ $item->name }}</td>
        <td>{{ $item->anak }}</td>
        <td>{{ \Carbon\Carbon::parse($item->tgl_lahir)->translatedFormat('d-m-Y') }}</td>
        <td>{{ $item->perkawinan }}</td>
        <td>{{ $item->status_sekolah }}</td>
        <td>{{ $item->status_beasiswa }}</td>
        <td>{{ $namaAyah }}</td>
        <td>{{ $anggota->nama }}</td>
        <td>{{ $item->tgl_meninggal_cerai ? \Carbon\Carbon::parse($item->tgl_meninggal_cerai)->translatedFormat('d-m-Y') : '-' }}</td>
        <td></td>
      </tr>
    @endforeach
  </table>

  <p class="mt-5" style="font-size: 14px;">II. Anak Kandung ( Ak ), Anak Tiri ( At ) dan Anak Angkat ( Aa ) yang masih tanggungan, tetapi tidak masuk dalam daftar gaji</p>
  <table class="page2-table">
    <?php $no = 1; ?>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Status<br>Anak (ak)<br>(at) (aa)</th>
      <th>Tanggal Lahir</th>
      <th>Belum<br>Pernah<br>Kawin</th>
      <th>Bersekolah/<br>Kuliah pada</th>
      <th>mendapat<br>1. Beasiswa/ darmasiswa<br>2. Ikatan Dinas</th>
      <th>bekerja atau<br>tidak bekerja</th>
      <th>Keterangan<br>diangkat menurut :<br>a. Putusan pengadilan<br>b. Hukum adopsi bagi<br>keturunan Cina</th>
    </tr>
    @if ($totalAnak2 == 0)
      <tr>
        <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
      </tr>
    @endif
    @foreach ($anakKategori2 as $item)
      <tr>
        <td><?php echo $no++; ?>.</td>
        <td class="text-left">{{ $item->name }}</td>
        <td>{{ $item->anak }}</td>
        <td>{{ \Carbon\Carbon::parse($item->tgl_lahir)->translatedFormat('d-m-Y') }}</td>
        <td>{{ $item->perkawinan }}</td>
        <td>{{ $item->status_sekolah }}</td>
        <td>{{ $item->status_beasiswa }}</td>
        <td>{{ $item->pekerjaan }}</td>
        <td></td>
      </tr>
    @endforeach
  </table>

  <p style="font-size: 14px;">A. Supaya dilampirkan salinan Surat Keputusan Pengadilan Negeri yang disahkan <br>B. Supaya diisi jika anak dilahirkan dari istri/suami yang telah meninggal dunia atau diceraikan</p>
</div>

<!-- ======================= TOMBOL (tidak ikut tercetak) ======================= -->
<div class="no-print" style="text-align:center; margin-top:20px;">
  <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
  <a href="{{ route('surat-kp4-olds.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
</div>

</body>
</html>