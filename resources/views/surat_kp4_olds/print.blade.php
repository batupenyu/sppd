<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Keterangan Tunjangan Keluarga - {{ $pegawai->nama ?? '' }}</title>
<style>
  @page { size: A4; margin: 15mm; }
  @page :first { size: A4 portrait; }
  * { box-sizing: border-box; }
  body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14pt;
    color: #111;
    max-width: 680px;
    margin: 0 auto;
    padding: 0;
    background: #fff;
  }
  .kop-surat-container { text-align: center; margin-bottom: 8px; }
  .kop-surat-image { max-width: 100%; max-height: 300px; height: auto; display: inline-block; }

  .title { text-align: center; margin: 14px 0 18px; }
  .title h3 { margin: 2px 0; font-size: 13px; text-decoration: underline; }

  table.fields {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
  }
  table.fields td {
    padding: 2px 4px;
    vertical-align: top;
    font-size: 12px;
  }
  table.fields td.no { width: 18px; }
  table.fields td.label { width: 190px; }
  table.fields td.colon { width: 12px; }

  .keterangan-block { margin: 12px 0 8px; font-size: 12px; }
  .keterangan-block p { margin: 3px 0; }
  .keterangan-block .indent { margin-left: 0px; }
  .keterangan-block .indent2 { margin-left: 14px; }

  table.tanggungan {
    width: 100%;
    border-collapse: collapse;
    margin: 8px 0 14px;
    font-size: 11px;
  }
  table.tanggungan th, table.tanggungan td {
    border: 1px solid #000;
    padding: 5px 6px;
    text-align: center;
  }
  table.tanggungan th { background: #f2f2f2; }

  .footer-note {
    font-size: 11px;
    text-align: justify;
    margin: 14px 0 30px;
    line-height: 1.4;
  }

  .signatures {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    font-size: 12px;
  }
  .sign-left { width: 45%; text-align: center; }
  .sign-right { width: 45%; text-align: center; margin-left: auto; }
  .sign-right .place-date { text-align: right; margin-bottom: 4px; margin-right: 10px;}
  .sign-space { height: 40px; }
  .sign-name { font-weight: normal; margin-top: 2px; }

  .page-break { page-break-before: always; margin-top: 20px; }
  .page2-table { width: 100%; border-collapse: collapse; margin: 8px 0 14px; font-size: 10px; table-layout: fixed; }
  .page2-table th, .page2-table td { border: 1px solid #000; padding: 4px 3px; text-align: center; word-wrap: break-word; }
  .page2-table th { background: #f2f2f2; }
  .page2-table .text-left { text-align: left !important; }
  .mt-5 { margin-top: 20px; }
    
  ul.roman-upper {
    list-style-type: upper-roman;
  }

  @media print {
    @page { size: A4 landscape; margin: 15mm; }
    @page :first { size: A4 portrait; margin: 15mm; }
    body { margin: 0; }
    .no-print { display: none !important; }
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
@endphp

  <!-- HALAMAN 1 -->
  <div id="page1-content">
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
      <td class="no">1</td>
      <td class="label">Nama Lengkap</td>
      <td class="colon">:</td>
      <td><strong>{{ $pegawai->nama ?? '' }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ ($pegawai->status_kepegawaian ?? '') === 'PNS' ? 'NIP' : 'NIPPPK' }}. {{ $pegawai->nip ?? '' }}</td>
    </tr>
    <tr>
      <td class="no">2</td>
      <td class="label">Tempat / Tanggal Lahir</td>
      <td class="colon">:</td>
      <td>{{ ($pegawai->tempat_lahir ?? '') }}{{ $pegawai && $pegawai->tanggal_lahir ? ', ' . $fmt($pegawai->tanggal_lahir) : '' }}</td>
    </tr>
    <tr>
      <td class="no">3</td>
      <td class="label">Jenis Kelamin</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->jk === 'L' ? 'Laki-laki' : ($pegawai->jk === 'P' ? 'Perempuan' : ($pegawai->jk ?? '-')) }}</td>
    </tr>
    <tr>
      <td class="no">4</td>
      <td class="label">Agama</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->agama ?? '' }}</td>
    </tr>
    <tr>
      <td class="no">5</td>
      <td class="label">Kebangsaan</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->kewarganegaraan ?? 'Indonesia' }}</td>
    </tr>
    <tr>
      <td class="no">6</td>
      <td class="label">Golongan / Status<br>Kepegawaian</td>
      <td class="colon">:</td>
      <td>{{ $golongan }}&nbsp;/ {{ $suratKp4Old->status_kepegawaian ?? ($pegawai->status_kepegawaian ?? '') }}</td>
    </tr>
    <tr>
      <td class="no">7</td>
      <td class="label">Jabatan Struktural/Fungsional</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->jabatan ?? '' }}{{ $pegawai->tugas_tambahan ? ' / ' . $pegawai->tugas_tambahan : '' }}</td>
    </tr>
    <tr>
      <td class="no">8</td>
      <td class="label">Pada Instansi, Dept. Lembaga</td>
      <td class="colon">:</td>
      <td>{{ $pegawai->unit_kerja ?? '' }}</td>
    </tr>
    <tr>
      <td class="no">9</td>
      <td class="label">Masa Kerja Golongan</td>
      <td class="colon">:</td>
      <td>{{ $suratKp4Old->masa_kerja_golongan ?? '-' }}</td>
    </tr>
    <tr>
      <td class="no">10</td>
      <td class="label">Digaji menurut</td>
      <td class="colon">:</td>
      <td>{{ $suratKp4Old->digaji_menurput ?? '-' }}</td>
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
    <p class="indent">a. Disamping Jabatan Utama tersebut, bekerja pula sebagai :</p>
    <p class="indent2">dengan mendapat penghasilan sebesar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp&nbsp;&nbsp;&nbsp;{{ $suratKp4Old->penghasilan_disamping ?? '-' }}&nbsp; sebulan</p>
    <p class="indent">b. Mempunyai Pensiun / Pensiun Janda&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp&nbsp;&nbsp;&nbsp;{{ $suratKp4Old->pensiun_janda ?? '-' }}&nbsp; sebulan</p>
    <p class="indent">c. Kawin sah dengan :</p>
    <p class="indent2">{{ $suratKp4Old->kawin_sah ?? '-' }}</p>
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
      <tr>
        <td>/</td>
        <td class="text-left">-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr>
        <td>/</td>
        <td class="text-left">-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
      </tr>
    </tbody>
  </table>

  <div class="keterangan-block">
    <p class="indent">d. Mempunyai anak &ndash; anak seperti dalam daftar sebelah ini, yaitu :</p>
    <ul style="list-style-type: upper-roman;margin-left: -13px;text-align: justify;">
      <li>
        <strong>Anak Kandung (Ak), Anak Tiri (At)</strong> yang masih menjadi tanggungan, belum mempunyai pekerjaan sendiri dan masuk dalam daftar Gaji.
      </li>
      <li>
        <strong>Anak Kandung (Ak), Anak Tiri (At), Anak Angkat (Aa)</strong> yang masih menjadi tanggungan, tetapi tidak termasuk dalam daftar Gaji.
      </li>
    </ul>
    <p class="indent">e. Jumlah anak seluruh ( {{ $suratKp4Old->anak->count() ?? 0 }} Orang ) yang menjadi tanggungan termasuk yang tidak termasuk dalam daftar gaji.</p>
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
      <p class="sign-name">{{ $penandatangan->nama ?? '' }}<br>{{ ($penandatangan->status_kepegawaian ?? '') === 'PPPK' ? '' : ($penandatangan->pangkat ?? '').($penandatangan->golongan ? ' / ' . $penandatangan->golongan : '') }}<br>NIP. {{ $penandatangan->nip ?? '' }}</p>
    </div>
    <div class="sign-right">
      <p>{{ $suratKp4Old->tempat_ditetapkan ?? '' }}, {{ $fmt($suratKp4Old->tanggal_ditetapkan ?? null) }}</p>
      <p>Yang Menerangkan,</p>
      <div class="sign-space"></div>
      <p class="sign-name">{{ $pegawai->nama ?? '' }}<br>{{ ($suratKp4Old->status_kepegawaian ?? '') === 'PPPK' ? '' : ($pegawai->pangkat ?? '').($pegawai->golongan ? ' / ' . $pegawai->golongan : '') }}<br>NIP. {{ $pegawai->nip ?? '' }}</p>
    </div>
  </div>

  </div>

  <div class="no-print" style="text-align:center; margin-top:20px;">
    <button onclick="window.print()" style="background:#2563eb; color:#fff; border:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem; cursor:pointer;">Cetak</button>
    <a href="{{ route('surat-kp4-olds.print-page2', $suratKp4Old) }}" target="_blank" style="display:inline-block; margin-left:0.5rem; background:#dc2525; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Cetak Halaman 2 (Landscape)</a>
    <a href="{{ route('surat-kp4-olds.index') }}" style="display:inline-block; margin-left:0.5rem; background:#6b7280; color:#fff; text-decoration:none; padding:0.6rem 1.4rem; border-radius:4px; font-size:0.95rem;">Kembali</a>
  </div>

</body>
</html>
